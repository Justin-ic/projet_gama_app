<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Slider;
use App\Models\Page;
use App\Models\About;
use App\Models\Actualite;
use App\Models\Client;
use App\Models\Event;
use App\Models\Gamme;
use App\Models\Keyword;
use App\Models\Offre;
use App\Models\Partenaire;
use App\Models\Philosophie;
use App\Models\Secteur;
use App\Models\User;
use App\Models\Publication;
use App\Models\Work;

class DataController extends Controller
{

    public static function index()
    {
        return self::makePage('home');
    }
    public static function makePage($slug = NULL)
    {
        $slug = $slug ?? 'home';
        session(['page_slug' => $slug]);
        $query = Page::with(['sections' => function ($q) {
            $q->orderBy('rang', 'ASC');
        }]);
        $page = $query->where('slug', strtolower($slug))->get()->toArray()[0] ?? [];
        if (!$page) :
            $slug = 'home';
            $query = Page::with(['sections' => function ($q) {
                $q->orderBy('rang', 'ASC');
            }]);
            $page = $query->where('slug', 'home')->get()->toArray()[0];
        endif;
        $data['template'] =  'master';
        $data['pageName'] = $page['name'] ?? env('APP_NAME');
        $data['pageTitle'] = $page['title'] ?? NULL;
        $data['page'] = $page;
        $data['pageKeywords'] = $page['keywords'] ?? NULL;
        $data['pageDescription'] = $page['description'] ?? NULL;
        $lesSections = $page['sections'] ?? [];
        $data['tabSection'] = [];
        $data['slug'] = $slug;
        foreach ($lesSections as $sect) :
            $data['tabSection'][] = $sect['vue'];
        endforeach;
        $data['tabSection'] = $page['sections'] ?? [];
        $data['data'] = self::getData($data['tabSection']);
        $data['tabSection'] = Arr::keyBy($data['tabSection'], 'vue');
        return view('page', $data);
    }

    public static function getData(array $sections): array
    {
        $data = [];
        foreach ($sections as $section) :
            $method  = "get" . ucfirst(camelCase($section['vue']));
            if (method_exists(self::class, $method)) :
                $data[$section['vue']] = call_user_func("self::$method");
            endif;
        endforeach;
        return $data;
    }

    public static function gammePage(int $gamme_id)
    {
        session(['gamme_id' => $gamme_id]);
        session(['breadcrump_specific' => true]);
        if ($gamme_id) :
            $data = Offre::with('gamme', 'type', 'secteurs')->where('gamme_id', $gamme_id)->get()->toArray();
            session(['dataOffrByGamme' => $data]);
            session(['breadcrump' => $data[0]['gamme'] ?? []]);
        else :
            session(['dataOffrByGamme' => []]);
            session(['breadcrump' => []]);
            session(['breadcrump_specific' => false]);
        endif;
        return self::makePage('offre-par-gamme');
    }

    public static function getBreadcrump()
    {
        if (session('page_slug') == 'offre-par-gamme') :
            return session('breadcrump');
        else :
            session(['breadcrump' => []]);
            return [];
        endif;
    }
    public static function getOffreByGamme()
    {
        $gamme_id = session('gamme_id', 0);
        $data = [];
        if ($gamme_id) :
            $data = session('dataOffrByGamme');
        endif;
        session(['gamme_id' => 0]);
        return $data;
    }
    public static function getClients()
    {
        return Client::where('actif', 1)->orderBy('rang', 'ASC')->get()->toArray();
    }

    public static function getPartenaire()
    {
        return Partenaire::where('actif', 1)->orderBy('rang', 'ASC')->get()->toArray();
    }
    public static function getSlider()
    {
        return Arr::keyBy(Slider::with('boutons')->where('active', true)
            ->orderBy('rang', 'ASC')->get()->toArray(), 'id');
    }
    public static function getAbout()
    {
        return About::orderBy('rang', 'ASC')->get()->toArray() ?? [];
    }
    public static function getPhilosophie()
    {
        return Philosophie::with('icone')->orderBy('rang', 'ASC')->get()->toArray() ?? [];
    }
    public static function getThumbnailImage(string $image, $suffixe = 'cropped'): string
    {
        $extension = pathinfo($image)["extension"];
        return str_replace(".$extension", "-$suffixe.$extension", $image);
    }

    public static function getSolution1()
    {
        $data = [];
        $data['secteurs'] = Secteur::with('offres', 'offres.type')->orderBy('rang', 'ASC')->get()->toArray() ?? [];
        $data['gammes'] = Gamme::orderBy('name', 'ASC')->get()->toArray() ?? [];
        return $data;
    }

    public static function offrePage(int $offre_id){
        session(['offres' => $offre_id]);
        return self::makePage('offre');
    }
    public static function getOffres(): array
    {
        $oic = session('offres', 0);
        $data = Arr::keyBy(Offre::with('gamme', 'secteurs', 'type')
                        ->where('id', '!=', $oic)
                        ->get()->toArray(), 'id');
        $offreCourante = [];
        if($oic != 0):
            $donnees = Offre::with(
                        'gamme', 'secteurs', 'descriptions',
                        'problematiques', 'formules', 'prices',
                        'forces', 'benefices', 'cibles', 'type'
                    )
                ->whereId($oic)
                ->get()->toArray();
            $offreCourante = $donnees[0] ?? [];
            session(['offres' => 0]);
        endif;
        return compact('data', 'offreCourante');
    }
    public static function getOffreDetail(){
        return self::getOffres();
    }
    public static function eventPage(int $event_id)
    {
        session(['event' => $event_id]);
        return self::makePage('event');
    }
    public static function getEvent(): array
    {
        $slug = 'event';
        $valeur_en_session = session($slug, 0);
        $data = Arr::keyBy(Event::where('id', '!=', $valeur_en_session)
            ->where('debut', '>=', date('Y-m-d'))
            ->orderBy('debut', 'ASC')
            ->get()->toArray(), 'id');
        $currentItem = [];
        if ($valeur_en_session != 0) :
            $donnees = Event::with(
                'descriptions',
                'contextes',
                'objectifs',
                'sponsorings',
                'cibles'
            )
                ->whereId($valeur_en_session)
                ->get()->toArray();
            $currentItem = $donnees[0] ?? [];
            session([$slug => 0]);
        endif;
        return compact('data', 'currentItem');
    }
    public static function getEventDetail()
    {
        return self::getEvent();
    }

    public static function actualitePage(Actualite $actualite_id)
    {
        session(['actualite' => $actualite_id]);
        return self::makePage('actualite');
    }
    public static function getActualite(){
        return Actualite::orderBy('created_at', 'desc')->limit(intval(setting('parametrage.nb_item_per_page')))->get()->toArray();
    }

    public static function getActualiteDetail() {
        $actualiteCourante = session('actualite', 0);
        if($actualiteCourante):
            $ActuDonnees = Arr::keyBy(Actualite::with('keywords')->where('id', '!=', $actualiteCourante->id)->get()->toArray(), 'id');
        else:
            $ActuDonnees = Arr::keyBy(Actualite::with('keywords')->get()->toArray(), 'id');
        endif;
        session(['actualite' => 0]);
        return compact('ActuDonnees', 'actualiteCourante');
    }


    public static function publicationPage(Publication $publication_id)
    {
        session(['publication' => $publication_id]);
        return self::makePage('publication');
    }
    public static function getPublication(){
        return Publication::orderBy('created_at', 'desc')->limit(intval(setting('parametrage.nb_item_per_page')))->get()->toArray();
    }

    public static function getPublicationDetail() {
        $publicationCourante = session('publication', 0);
        if($publicationCourante):
            $PublicationDonnees = Arr::keyBy(Publication::where('id', '!=', $publicationCourante->id)->get()->toArray(), 'id');
        else:
            $PublicationDonnees = Arr::keyBy(Publication::get()->toArray(), 'id');
        endif;
        session(['publication' => 0]);
        return compact('PublicationDonnees', 'publicationCourante');
    }


}


