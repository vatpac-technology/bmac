@extends('layouts.app')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Event</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('events.update', $event) }}">
                        @csrf
                        @method('PATCH')
                        {{--Name--}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"> Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name', $event->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Type--}}
                        <div class="form-group row">
                            <label for="eventType" class="col-md-4 col-form-label text-md-right"> Type</label>

                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('eventType') ? ' is-invalid' : '' }}"
                                        name="eventType">
                                    <option value="">Choose an event type...</option>
                                    @foreach($eventTypes as $eventType)
                                        <option value="{{ $eventType->id }}" {{ old('eventType', $event->event_type_id) == $eventType->id ? 'selected' : '' }}>{{ $eventType->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('eventType'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('eventType') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Only import?--}}
                        <div class="form-group row">
                            <label for="import_only" class="col-md-4 col-form-label text-md-right"> <abbr
                                        title="If enabled, only admins can fill in details via import script">Only
                                    import?</abbr></label>
                            <div class="col-md-6">
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="1" id="import_only1" name="import_only"
                                           class="custom-control-input" {{ old('import_only', $event->import_only) == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="import_only1">Yes</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="0" id="import_only0" name="import_only"
                                           class="custom-control-input" {{ old('import_only', $event->import_only) == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="import_only0">No</label>
                                </div>

                                @if ($errors->has('import_only'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('import_only') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Show times?--}}
                        <div class="form-group row">
                            <label for="uses_times" class="col-md-4 col-form-label text-md-right"> <abbr
                                        title="If enabled, CTOT and ETA (if set in booking) will be shown">Show
                                    times?</abbr></label>
                            <div class="col-md-6">
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="1" id="uses_times1" name="uses_times"
                                           class="custom-control-input" {{ old('uses_times', $event->uses_times) == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="uses_times1">Yes</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="0" id="uses_times0" name="uses_times"
                                           class="custom-control-input" {{ old('uses_times', $event->uses_times) == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="uses_times0">No</label>
                                </div>

                                @if ($errors->has('import_only'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('import_only') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Multiple bookings allowed?--}}
                        <div class="form-group row">
                            <label for="multiple_bookings_allowed" class="col-md-4 col-form-label text-md-right"> <abbr
                                        title="If enabled, a user is allowed to book multiple flights for this event">Multiple
                                    bookings allowed?</abbr></label>
                            <div class="col-md-6">
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="1" id="multiple_bookings_allowed1"
                                           name="multiple_bookings_allowed"
                                           class="custom-control-input" {{ old('multiple_bookings_allowed', $event->multiple_bookings_allowed) == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="multiple_bookings_allowed1">Yes</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="0" id="multiple_bookings_allowed0"
                                           name="multiple_bookings_allowed"
                                           class="custom-control-input" {{ old('multiple_bookings_allowed', $event->multiple_bookings_allowed) == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="multiple_bookings_allowed0">No</label>
                                </div>

                                @if ($errors->has('import_only'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('import_only') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Oceanic event?--}}
                        <div class="form-group row">
                            <label for="is_oceanic_event" class="col-md-4 col-form-label text-md-right"> <abbr
                                        title="If enabled, users can fill in a SELCAL code, and oceanic links are shown in the booking briefing">Oceanic
                                    event?</abbr></label>
                            <div class="col-md-6">
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="1" id="is_oceanic_event1" name="is_oceanic_event"
                                           class="custom-control-input" {{ old('is_oceanic_event', $event->is_oceanic_event) == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_oceanic_event1">Yes</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" value="0" id="is_oceanic_event0" name="is_oceanic_event"
                                           class="custom-control-input" {{ old('is_oceanic_event', $event->is_oceanic_event) == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_oceanic_event0">No</label>
                                </div>

                                @if ($errors->has('is_oceanic_event'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('is_oceanic_event') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Departure Airport--}}
                        <div class="form-group row">
                            <label for="dep" class="col-md-4 col-form-label text-md-right"> Departure Airport</label>

                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('dep') ? ' is-invalid' : '' }}"
                                        name="dep">
                                    <option value="">Choose an airport...</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->icao }}" {{ old('dep', $event->airportDep->icao) == $airport->icao ? 'selected' : '' }}>{{ $airport->icao }}
                                            [{{ $airport->name }} ({{ $airport->iata }})]
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('dep'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('dep') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Arrival Airport--}}
                        <div class="form-group row">
                            <label for="arr" class="col-md-4 col-form-label text-md-right"> Arrival Airport</label>

                            <div class="col-md-6">
                                <select class="custom-select form-control{{ $errors->has('arr') ? ' is-invalid' : '' }}"
                                        name="arr">
                                    <option value="">Choose an airport...</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->icao }}" {{ old('arr', $event->airportArr->icao) == $airport->icao ? 'selected' : '' }}>{{ $airport->icao }}
                                            [{{ $airport->name }} ({{ $airport->iata }})]
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('arr'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('arr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Date Event--}}
                        <div class="form-group row">
                            <label for="dateEvent" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa fa-calendar"></i> Date Event</label>

                            <div class="col-md-6">
                                <input type="text"
                                       class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }} datepicker"
                                       name="dateEvent" value="{{ old('dateEvent', $event->startEvent->format('d-m-Y')) }}" required>

                                @if ($errors->has('dateEvent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('dateEvent') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Time begin--}}
                        <div class="form-group row">
                            <label for="timeBeginEvent" class="col-md-4 col-form-label text-md-right"><i
                                        class="far fa-clock"></i> Begin (UTC)</label>

                            <div class="col-md-6">
                                <input id="timeBeginEvent" type="time"
                                       class="form-control{{ $errors->has('timeEndEvent') ? ' is-invalid' : '' }}"
                                       name="timeBeginEvent" value="{{ old('timeBeginEvent', $event->startEvent->format('H:i')) }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('timeBeginEvent') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Time end--}}
                        <div class="form-group row">
                            <label for="timeEndEvent" class="col-md-4 col-form-label text-md-right"><i
                                        class="far fa-clock fa-flip-horizontal"></i> End (UTC)</label>

                            <div class="col-md-6">
                                <input id="timeEndEvent" type="time"
                                       class="form-control{{ $errors->has('timeEndEvent') ? ' is-invalid' : '' }}"
                                       name="timeEndEvent" value="{{ old('timeEndEvent', $event->endEvent->format('H:i')) }}" required>

                                @if ($errors->has('timeEndEvent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('timeEndEvent') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Date--}}
                        <div class="form-group row">
                            <label for="dateBeginBooking" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa fa-calendar"></i> Date Start Bookings</label>

                            <div class="col-md-6">
                                <input type="text"
                                       class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }} datepicker"
                                       name="dateBeginBooking" value="{{ old('dateBeginBooking', $event->startBooking->format('d-m-Y')) }}" required>

                                @if ($errors->has('dateBeginBooking'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('dateBeginBooking') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Time begin--}}
                        <div class="form-group row">
                            <label for="timeBeginBooking" class="col-md-4 col-form-label text-md-right"><i
                                        class="far fa-clock"></i> Begin (UTC)</label>

                            <div class="col-md-6">
                                <input id="timeBeginEvent" type="time"
                                       class="form-control{{ $errors->has('timeBeginBooking') ? ' is-invalid' : '' }}"
                                       name="timeBeginBooking" value="{{ old('timeBeginBooking', $event->startBooking->format('H:i')) }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('timeBeginBooking') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Date--}}
                        <div class="form-group row">
                            <label for="dateEndBooking" class="col-md-4 col-form-label text-md-right"><i
                                        class="fa fa-calendar"></i> Date End Bookings</label>

                            <div class="col-md-6">
                                <input type="text"
                                       class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }} datepicker"
                                       name="dateEndBooking" value="{{ old('dateEndBooking', $event->endBooking->format('d-m-Y')) }}" required>

                                @if ($errors->has('dateBeginBooking'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('dateEndBooking') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Time end--}}
                        <div class="form-group row">
                            <label for="timeEndBooking" class="col-md-4 col-form-label text-md-right"><i
                                        class="far fa-clock fa-flip-horizontal"></i> End (UTC)</label>

                            <div class="col-md-6">
                                <input id="timeEndBooking" type="time"
                                       class="form-control{{ $errors->has('timeEndBooking') ? ' is-invalid' : '' }}"
                                       name="timeEndBooking" value="{{ old('timeEndBooking', $event->endBooking->format('H:i')) }}" required>

                                @if ($errors->has('timeEndBooking'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('timeEndBooking') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--Image--}}
                        <div class="form-group row">
                            <label for="image_url" class="col-md-4 col-form-label text-md-right"> Image</label>

                            <div class="col-md-6">
                                <input id="image" type="url"
                                       class="form-control{{ $errors->has('image_url') ? ' is-invalid' : '' }}"
                                       name="image_url"
                                       value="{{ old('image_url', $event->image_url) }}">

                                @if ($errors->has('image_url'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('image_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="form-group row">
                            <textarea id="description" name="description"
                                      rows="10">{!! html_entity_decode(old('description', $event->description)) !!}</textarea>
                        </div>

                        {{--Edit--}}
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Edit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection