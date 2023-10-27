<?php

namespace App\Http\Controllers\Guest;

use App\AccessoriesAlert;
use App\Chat;
use App\Http\Controllers\Controller;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Make;
use App\Models\Cars\Version;
use App\MyAlert;
use App\Page;
use App\PageDescription;
use App\UserSavedAds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Lang;
use DB;

class AdsController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function tags()
  {
    $activeLanguage = \Session::get('language');

    $page_descriptionQuery = Page::query()->select("pd.title", "pd.description");
    $page_descriptionQuery->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
    $page_description = $page_descriptionQuery->where('page_id', 7)->first();

    $page_descriptionQuery2 = Page::query()->select("pd.title", "pd.description");
    $page_descriptionQuery2->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
    $page_description_dealer = $page_descriptionQuery2->where('page_id', 8)->first();

    $page_descriptionQuery3 = Page::query()->select("pd.title", "pd.description");
    $page_descriptionQuery3->join('page_desciption AS pd', 'pages.id', '=', 'pd.page_id')->where('pd.language_id', $activeLanguage['id']);
    $page_descp = $page_descriptionQuery3->where('page_id', 9)->first();



    // dd($page_description_dealer);
    return view('guest.tags', compact('page_descp', 'page_description', 'page_description_dealer'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return view('guest.ads_details');
  }

  public function getMakers()
  {
    if (request()->ajax()) {
      $make_id = request()->get('make_id');
      $makes  =  make::where('status', 1)->orderBy('title', 'ASC')->get();
      $html = '';
      //$html = '<li class="heading"><h5>' . Lang::get('carDetailPage.popular_cars') . '</h5></li>';
      foreach ($makes as $make) {
        if (isset($make_id) && $make->id == $make_id) {
          $style = 'style="color:#005e9b"';
        } else $style = '';
        $html .= '<li data-maker="' . $make->id . '" id="maker_' . $make->id . '" >
              <a href="javascript:void(0);" class="align-items-center d-flex makes" data-make="' . $make->id . '" id="make_' . $make->id . '" data-title="' . $make->title . '" ' . $style . '>
                  <span class="car-make-logo ' . strtolower($make->title) . '"></span>' . $make->title . '<i class="fa ml-auto fa-angle-right"></i>
                  </a></li>';
      }
    } else {
      $html = response('Forbidden.', 403);
    }

    return $html;
  }

  public function getMakeModels($id)
  {
    if (request()->ajax()) {
      $model_id = request()->get('model_id');
      $models = Carmodel::where('make_id', $id)->where('status', 1)->orderBy('name', 'ASC')->get(); //abc
      $html = '';
      foreach ($models as $showmodels) {
        if (isset($model_id) && $showmodels->id == $model_id) {
          $style = 'style="color:#005e9b"';
        } else $style = '';

        $html .= '<li class="models"  data-model="' . $showmodels->id . '" id="model_' . $showmodels->id . '" data-title="' . $showmodels->name . '"><a href="javascript:void(0);" id="make_model_' . $showmodels->id . '" class="align-items-center d-flex justify-content-between" ' . $style . '>' . $showmodels->name . ' <i class="fa fa-angle-right"></i></a></li>';
      }
    } else {
      $html = response('Forbidden.', 403);
    }

    return $html;
  }

  public function getModelsVersions($model_id)
  {
    $html = '<h6 class="post-ad-modal-title d-flex align-items-center mb-4"><em class="d-md-none fa fa-arrow-circle-left gobackIcon mr-2"></em> ' . Lang::get('postCarAdPage.carInfoPopupVersion') . '</h6>
                        <div class="post-modal-list">
                        <ul class="list-unstyled version-listings">';
    if (request()->ajax()) {
      $versions = Version::where('model_id', $model_id)->get();
      $set_versions = array();
      if (!$versions->isEmpty()) {
        foreach ($versions as $show_versions) {
          $set_versions[$show_versions['label']][] = array(
            'vearsion_title' => $show_versions['label'],
            'extra_details' => $show_versions['extra_details'],
            'version_id' => $show_versions['id'],
            'cc' => $show_versions['cc'],
            'kilowatt' => $show_versions['kilowatt']
          );
        } // END FOREACH


        foreach ($set_versions as $keys => $versions_array) {
          $html .= ' <li class="heading"><h5>' . $keys . '</h5></li>';
          foreach ($versions_array as $versions_values) {
            $html .= '
                <li class="versions" data-title="' . $versions_values['vearsion_title'] . '"  data-version="' . $versions_values['version_id'] . '" id="version_' . $versions_values['version_id'] . '" data-cc="' . $versions_values['cc'] . '"  data-power="' . $versions_values['kilowatt'] . '"><a href="javascript:void(0);">' . $versions_values['cc'] . ' CC ' . $versions_values['extra_details'] . ' ' . $versions_values['kilowatt'] . ' KW</a></li>
                        ';
          } // END FOREACH INNER

        } // END FOREACH
      } // end of if
      else {
        $html .= '<li><a href="javascript:void(0);"><strong> ' . Lang::get('postCarAdPage.carInfoPopupNoData') . '</strong></a></li>';
      } // END OF ELSE

    } else {
      $html .= response('Forbidden.', 403);
    }
    $html .= '</ul></div>';
    return $html;
  }


  public function getModelsByYearVersions($model_id, $year)
  {
    $activeLanguage = \Session::get('language');
    $html = '';
    if (request()->ajax()) {
      DB::enableQueryLog();
      $versionsLabels     = Version::select("label", "engine_capacity", 'engine_power')->distinct('label')
        ->where('model_id', $model_id)->whereRaw("'" . $year . "' >= from_date")
        ->whereRaw("(to_date ='.' OR '" . $year . "' <= to_date)")/* ->whereNotNull('cc')->whereNotNull('kilowatt') */ 
        ->orderBy('engine_capacity', "ASC")->orderBy('engine_power', "ASC")->get();
      /* $query = DB::getQueryLog();
      $query = end($query);
      dd($query); */
      $set_versions = array();
      if ($versionsLabels->isEmpty()) {
        $html .= '<li><a href="javascript:void(0);"><strong> ' . Lang::get('postCarAdPage.carInfoPopupNoData') . '</strong></a></li>';
      } // END OF ELSE
      else {
        foreach ($versionsLabels as $keys => $versions_array) {
          $versions     = Version::query()->select(
            'label',
            'extra_details',
            'versions.id as version_id',
            'cc as capacity',
            'kilowatt as engine_power',
            'engine_capacity',//Liter
            'from_date',
            'to_date',
            'bt.name AS body_name',
            't.title AS transmission'
          )
          ->distinct('versions.id')
          ->where('model_id', $model_id)->where('label', "$versions_array->label")->whereRaw("'" . $year . "' >= from_date")
            ->whereRaw("(to_date ='.' OR '" . $year . "' <= to_date)");

          $versions->leftJoin('transmission_description AS t', function ($join) use ($activeLanguage) {
            $join->on('versions.transmissiontype', '=', 't.transmission_id');
            $join->where('t.language_id', $activeLanguage['id']);
          });
          $versions->leftJoin('body_types_description AS bt', function ($join) use ($activeLanguage) {
            $join->on('versions.body_type_id', '=', 'bt.body_type_id');
            $join->where('bt.language_id', $activeLanguage['id']);
          });
          $versions->orderBy('capacity', "ASC")->orderBy('transmission', "ASC")->orderBy('body_name', "ASC");
          $version       = $versions->get(); 
          $version_title = $versions_array->label; //$label[0] . $engine_power. ' KW';

          $html .= ' <li class="heading"><h5>' . $version_title . '</h5></li>';
          $singleCount = count($version);
          foreach ($version as $versions_values) {
            $html .= '<li class="versions" data-title="' . $version_title . '"  data-version="' . $versions_values->version_id . '" id="version_' . $versions_values->version_id . '" data-cc="' . $versions_values->engine_capacity . '"  data-power="' . $versions_values->engine_power . '" data-transmission_body="' . $versions_values->transmission . ' ' . $versions_values->body_name . '">';
            $html .= '<a href="javascript:void(0);">';
            if(!empty($versions_values->capacity))
            {
              $html .= $versions_values->capacity . ' CC ';
            }
            $html .= $versions_values->transmission . ' ' . $versions_values->body_name;
            if (!empty($versions_values->extra_details) && $singleCount > 1) {
              $html .= '<br/>(' . $versions_values->extra_details . ')';
            }
            $html .= '</a></li>';
          } // END FOREACH INNER
        } // END FOR EACH OUTER
      } // end of else 
      /*  $query = DB::getQueryLog();
      $query = end($query);
      dd($query); */
    } else {
      $html .= response('Forbidden.', 403);
    }
    return $html;
  }

  public function makeAccessoryAlert(Request $request)
  {
    $alert = new AccessoriesAlert;
    $alert->category_id     = @$request->category;
    $alert->customer_id     = @Auth::guard('customer')->user()->id;
    $alert->sub_category_id = 'Any';
    $alert->city            = 'Any';
    $alert->price_from      = 'Any';
    $alert->price_to        = 'Any';
    $alert->frequency       = @$request->frequency;
    $alert->save();
    return response()->json(['success' => true]);
  }

  public function makeCarAlert(Request $request)
  {
    $alert               = new MyAlert;
    $alert->car_make     = 'Any';
    $alert->customer_id  = @Auth::guard('customer')->user()->id;
    $alert->car_model    = @$request->model;
    $alert->city         = 'Any';
    $alert->price_from   = 'Any';
    $alert->price_to     = 'Any';
    $alert->year_from    = 'Any';
    $alert->year_to      = 'Any';
    $alert->mileage_from = 'Any';
    $alert->mileage_to   = 'Any';
    $alert->transmission = 'Any';
    $alert->frequenct    = @$request->selectType;
    $alert->save();
    return response()->json(['success' => true]);
  }

  public function addToSavedAds($id, CookieJar $cookieJar, Request $request)
  {
    $check = $request->cookie('ad' . $id);
    if ($check == null) {
      $cookieJar->queue(cookie()->forever('ad' . $id, 'done'));
      return response()->json(['success' => true]);
    } else {
      $cookieJar->queue(cookie()->forget('ad' . $id));
      return response()->json(['success' => false]);
    }
  }

  public function addToSavedSparePartAds($id, CookieJar $cookieJar, Request $request)
  {
    $check = $request->cookie('sparepartad' . $id);
    if ($check == null) {

      $cookieJar->queue(cookie()->forever('sparepartad' . $id, 'done'));
      return response()->json(['success' => true]);
    } else {
      $cookieJar->queue(cookie()->forget('sparepartad' . $id));
      return response()->json(['success' => false]);
    }
  }

  public function checkMessages(Request $request)
  {
    $chat = Chat::where('to_id', $request->customer_id)->where('from_id', Auth::guard('customer')->user()->id)->where('ad_id', $request->ads_id)->where('type', $request->ads_type)->get();
    if ($chat->count() > 0) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }


  public function tagsSuggestion(Request $request)
  {
    // dd($request->all());
    if (Auth::guard('customer')->user()) {
      $email = Auth::guard('customer')->user()->customer_email_address;
      $html = '
        <h4> Category : ' . $request->category . '</h4><p><strong>Tag Title : </strong>' . $request->title . '<br><strong>Tag Description : </strong>' . $request->description . '</p>
      ';
      Mail::send(array(), array(), function ($message) use ($html, $email) {
        $message->to('developer@carish.ee')
          ->subject('Tag Suggestion')
          ->from($email)
          ->setBody($html, 'text/html');
      });

      return redirect()->back()->with('tag_sent', 'Successfull!');
    } else {
      // dd('here');
      return redirect()->back()->with('please_login', 'Failed!');
    }
  }
}
