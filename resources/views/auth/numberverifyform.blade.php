@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Laravel Phone Number Authentication using Firebase - ItSolutionStuff.com</h1>

        <div class="alert alert-danger" id="error" style="display: none;"></div>

        <div class="card">
            <div class="card-header">
                Enter Phone Number
            </div>
            <div class="card-body">
                <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
                <form>
                    <label>Phone Number:</label>
                    <input type="text" id="number" class="form-control" placeholder="+91********">
                    <div id="recaptcha-container"></div>
                    <button type="button" class="btn btn-success" onclick="phoneSendAuth();">SendCode</button>
                </form>
            </div>
        </div>

        <div class="card" style="margin-top: 10px">
            <div class="card-header">
                Enter Verification code
            </div>
            <div class="card-body">
                <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
                <form>
                    <input type="text" id="verificationCode" class="form-control" placeholder="Enter verification code">
                    <button type="button" class="btn btn-success" onclick="codeverify();">Verify code</button>
                </form>
            </div>
        </div>

    </div>

@endsection
