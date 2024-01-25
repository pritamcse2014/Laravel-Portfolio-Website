@extends('Layout.app')

@section('title', 'Contact')

@section('content')

    <div class="container-fluid jumbotron mt-5 ">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6  text-center">
                <h1 class="page-top-title mt-3">- যোগাযোগ করুন -</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-white jumbotron mt-5 ">
        <div class="row">
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7302.570964262903!2d90.34950249140587!3d23.772846333155968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c0bcdf50fd59%3A0x9ab0a63bb3267107!2sAdabar%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1696878083553!5m2!1sen!2sbd" width=650" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6">
                <h3 class="service-card-title">ঠিকানা</h3>
                <hr>
                <p class="footer-text"><i class="fas ml-2 fa-map-marker-alt"></i> শেখেরটেক ৮ মোহাম্মদপুর, ঢাকা </p>
                <hr>
                <p class="footer-text"><i class="fas ml-2 fa-phone"></i> ০১৭৮৫৩৮৮৯১৯ </p>
                <hr>
                <p class="footer-text"><i class="fas ml-2 fa-envelope"></i> Rabbil@Yahoo.com </p>
                <div class="form-group">
                    <input id="contactNameId" type="text" class="form-control w-100" placeholder="আপনার নাম">
                </div>
                <div class="form-group">
                    <input id="contactMobileId" type="text" class="form-control  w-100" placeholder="মোবাইল নং ">
                </div>
                <div class="form-group">
                    <input id="contactEmailId" type="text" class="form-control  w-100" placeholder="ইমেইল ">
                </div>
                <div class="form-group">
                    <input id="contactMessageId" type="text" class="form-control  w-100" placeholder="মেসেজ ">
                </div>
                <button id="contactSendBtnId" class="btn btn-block normal-btn w-100">পাঠিয়ে দিন </button>
            </div>
        </div>
    </div>

@endsection
