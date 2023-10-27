<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmailTemplate;
use App\EmailTemplateDescription;
use App\EmailType;
use Auth;
use App\Models\Language;


class TemplateController extends Controller
{
    public function index()
    {
    	$templates = EmailTemplate::where('status',1)->latest()->get();
        // dd($templates[0]->emailTemplateDescription[0]);
        return view('admin.templates.index',compact('templates'));
    }

    public function create()
    {
        $languages = Language::all();
        $emailTypes = EmailType::where('status',1)->get();

        return view('admin.templates.create' ,compact('languages','emailTypes'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // create new template //
        $template 			= new EmailTemplate;
        $template->type 	= $request->type;
        $template->updated_by   = Auth::user()->id;
        $template->save();

        $languages = Language::all();

        foreach ($languages as $language) {
        $email_description = new EmailTemplateDescription;
        $email_description->email_template_id = $template->id;

        $email_subject = $language->language_code.'_add_subject';
        $email_description->subject = $request->$email_subject;

        $email_content = $language->language_code.'_add_content'; 
        $email_description->content = $request->$email_content;

        $email_description->language_id = $language->id;
        $email_description->save();
        }

        return redirect()->route('list-template')->with('successmsg', 'New Template added successfully');
    }

    public function edit($id)
    {
    	$template = EmailTemplate::find($id);
        $languages = Language::all();
        $emailTypes = EmailType::where('status',1)->get();

        return view('admin.templates.edit',compact('template','languages'));
    }

    public function update(Request $request, $id)
    {
        $template           = EmailTemplate::find($id);
        $template->updated_by   = Auth::user()->id;
        $template->save();

        $languages = Language::all();

        foreach ($languages as $language) {
        $email_description = EmailTemplateDescription::where('email_template_id' , $id)->where('language_id', $language->id)->first();

        $email_subject = $language->language_code.'_add_subject';
        $email_description->subject = $request->$email_subject;

        $email_content = $language->language_code.'_add_content'; 
        $email_description->content = $request->$email_content;

        $email_description->language_id = $language->id;
        $email_description->save();
        }

        return redirect()->route('list-template')->with('successmsg', 'Template updated successfully');
    }
}
