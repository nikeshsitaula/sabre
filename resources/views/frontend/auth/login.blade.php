@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h5 class="active"
                style="padding-top: 10px; padding-bottom: 10px; color: #FF3232;    background-color: #ffffff;"> Sign
                In </h5>


            <!-- Icon -->
            <div class="fadeIn first">
                <img src="{{asset("img/frontend/sabre-logo-slab.svg")}}" id="icon" alt="User Icon"
                     style="width: 37%; padding: 24px;"/>
            </div>

            <!-- Login Form -->

            {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
            @csrf
            <input type="text" id="login" class="fadeIn second" name="email" placeholder="login">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        {{ html()->form()->close() }}

        <!-- Remind Passowrd -->
            <div id="formFooter">
{{--                <a class="underlineHover" href="#" style="color: #FF3232;">Forgot Password?</a>--}}
            </div>

        </div>
    </div>

@endsection
