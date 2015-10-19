
public function store(Request $request)
{
	$validator = Validator::make($request->all(), [
	    'poster' => 'required|mimes:ppt,pptx,pdf|max:10240',
	]);

	if ($validator->fails()) {
	    Session::flash('alert','Error');
	    return Redirect::to('/home');
	}

	if ($request->hasFile('file')) {

	    $name_new = $request->get('user_id'). '-' .
	            Carbon::now()->day.Carbon::now()->month.Carbon::now()->hour.Carbon::now()->minute. '.' .
	            $request->file('poster')->getClientOriginalExtension();
	    //Storage::disk('local')->put($name, $request->file('poster'));
	    $request->file('poster')->move(base_path() . '/public/archivos', $name_new);

	    $name_old =   $request->file('poster')->getClientOriginalName();

	    $attachment = new Attachment(array(
	        'user_id' => $request->get('user_id'),
	        'name_old'  => $name_old,
	        'name_new' => $name_new
	    ));

	    $attachment->save();
	    Session::flash('success','File saved');
	    return Redirect::to('/home/');
	}

	Session::flash('alert','Error in file upload');
	return Redirect::to('/home');
}
