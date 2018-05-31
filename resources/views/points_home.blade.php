@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <!-- Styles -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Speed Limits</div>

                    <div id="main" class="panel-body">
    
                        <form id="main-form" class="pure-form" onsubmit="return false;">
                            <fieldset>
                                <legend>Enter your starting and ending point</legend>

                                <input type="text" class="autocomplete-start" placeholder="Geo Latitude">
                                <input type="text" class="autocomplete-end" placeholder="Geo Longitude">

                                <button id="search" type="submit" class="pure-button pure-button-primary">Search</button>
                            </fieldset>
                            <fieldset>
                                <button id="default" type="submit" class="pure-button pure-button-primary">Use Default</button>
                            </fieldset>
                        </form>
                        
                        <div id="boxes">
                            <div class="col-md-3">
                                <div class="box">
                                    <p class="number">125</p>
                                    <p>Points Updated</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p class="number">125</p>
                                    <p>Points Updated</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p class="number">125</p>
                                    <p>Points Updated</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p class="number">125</p>
                                    <p>Points Updated</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12"><div class="success"></div></div>
                        <div class="col-md-12"><div class="error"></div></div>

                        
                        <div class="col-md-3"><div id="sidebar"></div></div>
                        <div class="col-md-9">

                                <div id="map"></div>
                        
                                <form class="pure-form automatic-update">
                                    <label for="option-one" class="pure-checkbox" style="font-size: small; color: #1c85c5;">
                                        <input id="automatic-update" type="checkbox" value="">
                                        Automatic update on drag and drop? Needs to be uncheked if you want to edit your markers with click.
                                    </label>
                                </form>
                        </div>
                        
                        <div id="modal">
                            <form class="pure-form" onsubmit="return false;">
                                <fieldset id="update-geo">
                                    <legend>Old Geo Coordinates</legend>
                                    <input readonly name="old_geo_lat" placeholder="Old Geo Latitude">
                                    <input readonly name="old_geo_lon" placeholder="Old Geo Longitude">
                                </fieldset>
                                <fieldset>
                                    <legend>New Geo Coordinates</legend>
                                    <input type="text" name="latitude" placeholder="New Geo Latitude">
                                    <input type="text" name="longitude" placeholder="New Geo Longitude">
                                </fieldset>
                                <fieldset>
                                    <legend>Speed and Name</legend>
                                    <input type="text" name="speed" placeholder="Speed" style="width: 25%; float: left; margin-right: 10px;">
                                    <input type="text" name="name" placeholder="Name" style="width: 70%; float: left;">
                                </fieldset>
                                <fieldset>
                                    <button id="update-point" type="submit" class="pure-button pure-button-primary">Update</button>
                                    <button id="delete-point" type="submit" class="pure-button button-error">Delete</button>
                                    <a class="close cancel pure-button" href="#">Cancel</a>
                                </fieldset>
                                <input type="hidden" name="id" />
                            </form>
                        </div>

                        <div id="create-modal" style="display: none;">
                            <form class="pure-form" onsubmit="return false;">
                                <fieldset>
                                    <legend>Speed and Name</legend>
                                    <input type="text" name="new_speed" placeholder="Speed" style="width: 25%; float: left; margin-right: 10px;">
                                    <input type="text" name="new_name" placeholder="Name" style="width: 70%; float: left;">
                                </fieldset>
                                <fieldset>
                                    <legend>Provincia and Type</legend>
                                    <input type="text" name="new_provincia" placeholder="Provincia">
                                    <input type="text" name="new_type" placeholder="Type">
                                </fieldset>
                                <fieldset>
                                    <legend>Road Reference and Subtype</legend>
                                    <input type="text" name="new_road_reference" placeholder="Road Reference">
                                    <input type="text" name="new_sub_type" placeholder="Sub Type">
                                </fieldset>
                                <fieldset>
                                    <button id="create-point" type="submit" class="pure-button pure-button-primary">Create</button>
                                    <a class="close cancel pure-button" href="#">Cancel</a>
                                </fieldset>
                                <input type="hidden" name="new_latitude" />
                                <input type="hidden" name="new_longitude" />
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
        <!-- Scripts --> 

        <script type="text/javascript">
            token = '{{ csrf_token() }}';
            // Google Map
            $(document).ready(function() {

                minZoom = {{ $default_zoom }};
                map_init({{ $geo_lat }}, {{ $geo_lon }}, minZoom);
                dx = {{ $dx }}, dy = {{ $dy }};
                
            });

        </script>
@endsection

