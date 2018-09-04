 <br />
{{-- Company Identity --}}
 <div class="portlet-title">
     <div class="caption font-green-sharp">
        <i class="fa fa-globe font-green-sharp"></i>&nbsp;
        <span class="caption-subject bold uppercase">Site Preferences/ SEO</span>
    </div>
 </div>

 <div class="portlet-body">
    <div class="row form-horizontal form-body">
        <div class="col-md-12">

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Site Name</label>
                <div class="col-md-10">
                    <input class="form-control" id="site-name" type="text" name="settings[site-name]" value="{{ settings('site-name') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Site Description</label>
                <div class="col-md-10">
                    <textarea rows="3" class="form-control" id="site-description" type="text" name="settings[site-description]">{{ settings('site-description') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Site Image</label>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" id="file_url" name="logo_url" value="{{ settings('logo_url') }}"> </span>
                                <input type="hidden" value="{{ settings('logo_url') }}" name="logo_url">
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                        <span class="help-block">Minimum height 50 px</span>
                    </div>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label" for=""></label>
                <div class="col-md-10">
                    @if(empty(settings('logo_url')))
                        <i>( No Image )</i>
                    @else
                        <figure>
                            <img class='thumbnail' src="{{ settings('logo_url') }}" style='max-height: 50px' alt=''>
                        </figure>
                    @endif
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Google Analytics Script</label>
                <div class="col-md-10">
                    <textarea rows="5" class="form-control" id="ga_script" name="settings[ga_script]">{{ settings('ga_script') }}</textarea>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Label Setting --}}
 <div class="portlet-title">
     <div class="caption font-green-sharp">
        <i class="fa fa-calendar font-green-sharp"></i>&nbsp;
        <span class="caption-subject bold uppercase">Label/ Wording Setting</span>
    </div>
 </div>

 <div class="portlet-body">
    <div class="row form-horizontal form-body">
        <div class="col-md-12">

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Profile</label>
                <div class="col-md-10">
                    <textarea rows="3" class="form-control" id="profile" type="text" name="settings[profile]">{{ settings('profile') }}</textarea>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">History</label>
                <div class="col-md-10">
                    <textarea rows="3" class="form-control" id="history" type="text" name="settings[history]">{{ settings('history') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">History Image</label>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" id="file_url" name="history-image" value="{{ settings('history-image') }}"> </span>
                                <input type="hidden" value="{{ settings('history-image') }}" name="history-image">
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label" for=""></label>
                <div class="col-md-10">
                    @if(empty(settings('history-image')))
                        <i>( No Image )</i>
                    @else
                        <figure>
                            <img class='thumbnail' src="{{ settings('history-image') }}" style='max-height: 150px' alt=''>
                        </figure>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Site Plan 1</label>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" id="file_url" name="site-plan-1" value="{{ settings('site-plan-1') }}"> </span>
                                <input type="hidden" value="{{ settings('site-plan-1') }}" name="site-plan-1">
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label" for=""></label>
                <div class="col-md-10">
                    @if(empty(settings('site-plan-1')))
                        <i>( No Image )</i>
                    @else
                        <figure>
                            <img class='thumbnail' src="{{ settings('site-plan-1') }}" style='max-height: 150px' alt=''>
                        </figure>
                        <input type="checkbox" name="settings[site-plan-1]" id="delete_file__site-plan-1"> <label for="delete_file__site-plan-1">Delete Current File</label>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Site Plan 2</label>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" id="file_url" name="site-plan-2" value="{{ settings('site-plan-2') }}"> </span>
                                <input type="hidden" value="{{ settings('site-plan-2') }}" name="site-plan-2">
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label" for=""></label>
                <div class="col-md-10">
                    @if(empty(settings('site-plan-2')))
                        <i>( No Image )</i>
                    @else
                        <figure>
                            <img class='thumbnail' src="{{ settings('site-plan-2') }}" style='max-height: 150px' alt=''>
                        </figure>
                        <input type="checkbox" name="settings[site-plan-2]" id="delete_file__site-plan-2"> <label for="delete_file__site-plan-2">Delete Current File</label>
                    @endif
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Train Route</label>
                <div class="col-md-10">
                    <textarea rows="3" class="form-control" id="train-route" type="text" name="settings[train-route]">{{ settings('train-route') }}</textarea>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Bus Route</label>
                <div class="col-md-10">
                    <textarea rows="3" class="form-control" id="bus-route" type="text" name="settings[bus-route]">{{ settings('bus-route') }}</textarea>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Description in Footer</label>
                <div class="col-md-10">
                    <textarea rows="3" class="form-control" id="footer-description" type="text" name="settings[footer-description]">{{ settings('footer-description') }}</textarea>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Link Setting --}}
 <div class="portlet-title">
     <div class="caption font-green-sharp">
        <i class="fa fa-calendar font-green-sharp"></i>&nbsp;
        <span class="caption-subject bold uppercase">Link Setting</span>
    </div>
 </div>

 <div class="portlet-body">
    <div class="row form-horizontal form-body">
        <div class="col-md-12">

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Official Email</label>
                <div class="col-md-10">
                    <input class="form-control" id="official-email" type="text" name="settings[official-email]" value="{{ settings('official-email') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Official Phone</label>
                <div class="col-md-10">
                    <input class="form-control" id="official-phone" type="text" name="settings[official-phone]" value="{{ settings('official-phone') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Facebook Link</label>
                <div class="col-md-10">
                    <input class="form-control" id="official-facebook" type="text" name="settings[official-facebook]" value="{{ settings('official-facebook') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Twitter Link</label>
                <div class="col-md-10">
                    <input class="form-control" id="official-twitter" type="text" name="settings[official-twitter]" value="{{ settings('official-twitter') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Instagram Link</label>
                <div class="col-md-10">
                    <input class="form-control" id="official-instagram" type="text" name="settings[official-instagram]" value="{{ settings('official-instagram') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">App Store Link</label>
                <div class="col-md-10">
                    <input class="form-control" id="official-app-store" type="text" name="settings[official-app-store]" value="{{ settings('official-app-store') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Google Play Store Link</label>
                <div class="col-md-10">
                    <input class="form-control" id="official-play-store" type="text" name="settings[official-play-store]" value="{{ settings('official-play-store') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Spotify Playlist Link</label>
                <div class="col-md-10">
                    <input class="form-control" id="spotify-playlist-url" type="text" name="settings[spotify-playlist-url]" value="{{ settings('spotify-playlist-url') }}">
                </div>
            </div>

        </div>
    </div>
</div>


{{-- Mobile App Setting --}}
<div class="portlet-title">
     <div class="caption font-green-sharp">
        <i class="fa fa-calendar font-green-sharp"></i>&nbsp;
        <span class="caption-subject bold uppercase">Label/ Wording Setting</span>
    </div>
</div>

<div class="portlet-body">
    <div class="row form-horizontal form-body">
        <div class="col-md-12">

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Jumlah Tiket Terjual</label>
                <div class="col-md-10">
                    <input class="form-control" id="ticket_sold" type="text" name="settings[ticket_sold]" value="{{ settings('ticket_sold') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Video in Homepage</label>
                <div class="col-md-10">
                    <input class="form-control" id="mobile_app_home_video" type="text" name="settings[mobile_app_home_video]" value="{{ settings('mobile_app_home_video') }}">
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Event Date (For Countdown)</label>
                <div class="col-md-10">
                    <input data-datetime-input class="form-control" name="settings[event_start_date]" value="{{ settings('event_start_date') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Profile Image (Mobile App)</label>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                <span class="fileinput-new"> Select file </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" id="file_url" name="profile_image" value="{{ settings('profile_image') }}"> </span>
                                <input type="hidden" value="{{ settings('profile_image') }}" name="profile_image">
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>

            <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label" for=""></label>
                <div class="col-md-10">
                    @if(empty(settings('profile_image')))
                        <i>( No Image )</i>
                    @else
                        <figure>
                            <img class='thumbnail' src="{{ settings('profile_image') }}" style='max-height: 150px' alt=''>
                        </figure>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
