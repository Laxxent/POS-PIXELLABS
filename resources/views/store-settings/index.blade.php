@extends('layouts.app')

@section('title', 'Store Settings - POS Application')
@section('page-title', 'Store Settings')

@section('styles')
<style>
    .currency-dropdown {
        position: relative;
    }
    
    .currency-dropdown .form-select {
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        -ms-appearance: none !important;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23343a40' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 40px;
        background-color: white;
        border: 1px solid #ced4da;
    }
    
    .currency-option {
        display: flex;
        align-items: center;
        padding: 0.5rem;
    }
    
    .currency-code {
        font-weight: 600;
        color: #495057;
        min-width: 50px;
    }
    
    .currency-name {
        color: #6c757d;
        margin-left: 0.5rem;
    }
    
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    /* Dark mode support */
    [data-theme="dark"] .currency-dropdown .form-select {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
        background-color: #2d3748;
        border-color: #4a5568;
        color: #e9ecef;
    }
    
    [data-theme="dark"] .currency-dropdown .form-select:focus {
        background-color: #2d3748;
        border-color: #667eea;
        color: #e9ecef;
    }
    
    [data-theme="dark"] .currency-dropdown .form-select option {
        background-color: #2d3748;
        color: #e9ecef;
    }
    
    /* Remove default browser dropdown arrows */
    .currency-dropdown .form-select::-ms-expand {
        display: none !important;
    }
    
    .currency-dropdown .form-select::-webkit-outer-spin-button,
    .currency-dropdown .form-select::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }
    
    .currency-dropdown .form-select::-moz-appearance {
        -moz-appearance: none !important;
    }
    
    .currency-dropdown .form-select::-o-appearance {
        -o-appearance: none !important;
    }
    
    .currency-dropdown .form-select {
        -webkit-border-radius: 0 !important;
        -moz-border-radius: 0 !important;
        border-radius: 0.375rem !important;
        outline: none !important;
    }
    
    /* Force arrow visibility in dark mode */
    [data-theme="dark"] .currency-dropdown .form-select {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 20px !important;
    }
    
    /* Ensure arrow is always visible */
    .currency-dropdown .form-select:focus {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23343a40' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
    }
    
    [data-theme="dark"] .currency-dropdown .form-select:focus {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
    }
    
    /* Additional override for dark mode arrow */
    [data-theme="dark"] .currency-dropdown .form-select,
    [data-theme="dark"] .currency-dropdown .form-select:hover,
    [data-theme="dark"] .currency-dropdown .form-select:active,
    [data-theme="dark"] .currency-dropdown .form-select:focus {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 20px !important;
    }
    
    /* Ultra aggressive override for dark mode */
    html[data-theme="dark"] .currency-dropdown .form-select,
    html[data-theme="dark"] .currency-dropdown .form-select:hover,
    html[data-theme="dark"] .currency-dropdown .form-select:active,
    html[data-theme="dark"] .currency-dropdown .form-select:focus,
    html[data-theme="dark"] .currency-dropdown .form-select:visited {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 20px !important;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span>{{ __('Store Settings') }}</span>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('store-settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row mb-3">
                            <label for="store_name" class="col-md-4 col-form-label text-md-right">{{ __('Store Name') }}</label>
                            <div class="col-md-6">
                                <input id="store_name" type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="{{ $settings->store_name ?? old('store_name') }}" required>
                                @error('store_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" required>{{ $settings->address ?? old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $settings->phone ?? old('phone') }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $settings->email ?? old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="currency" class="col-md-4 col-form-label text-md-right">{{ __('Currency') }}</label>
                            <div class="col-md-6">
                                <div class="currency-dropdown">
                                    <select id="currency" class="form-select @error('currency') is-invalid @enderror" name="currency" required>
                                        <option value="">-- Pilih Currency --</option>
                                    <option value="IDR" {{ ($settings->currency ?? old('currency')) == 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                                    <option value="USD" {{ ($settings->currency ?? old('currency')) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ ($settings->currency ?? old('currency')) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="GBP" {{ ($settings->currency ?? old('currency')) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                    <option value="JPY" {{ ($settings->currency ?? old('currency')) == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                                    <option value="SGD" {{ ($settings->currency ?? old('currency')) == 'SGD' ? 'selected' : '' }}>SGD - Singapore Dollar</option>
                                    <option value="MYR" {{ ($settings->currency ?? old('currency')) == 'MYR' ? 'selected' : '' }}>MYR - Malaysian Ringgit</option>
                                    <option value="THB" {{ ($settings->currency ?? old('currency')) == 'THB' ? 'selected' : '' }}>THB - Thai Baht</option>
                                    <option value="PHP" {{ ($settings->currency ?? old('currency')) == 'PHP' ? 'selected' : '' }}>PHP - Philippine Peso</option>
                                    <option value="VND" {{ ($settings->currency ?? old('currency')) == 'VND' ? 'selected' : '' }}>VND - Vietnamese Dong</option>
                                    <option value="AUD" {{ ($settings->currency ?? old('currency')) == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                                    <option value="CAD" {{ ($settings->currency ?? old('currency')) == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                    <option value="CHF" {{ ($settings->currency ?? old('currency')) == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc</option>
                                    <option value="CNY" {{ ($settings->currency ?? old('currency')) == 'CNY' ? 'selected' : '' }}>CNY - Chinese Yuan</option>
                                    <option value="HKD" {{ ($settings->currency ?? old('currency')) == 'HKD' ? 'selected' : '' }}>HKD - Hong Kong Dollar</option>
                                    <option value="KRW" {{ ($settings->currency ?? old('currency')) == 'KRW' ? 'selected' : '' }}>KRW - South Korean Won</option>
                                    <option value="NZD" {{ ($settings->currency ?? old('currency')) == 'NZD' ? 'selected' : '' }}>NZD - New Zealand Dollar</option>
                                    <option value="SEK" {{ ($settings->currency ?? old('currency')) == 'SEK' ? 'selected' : '' }}>SEK - Swedish Krona</option>
                                    <option value="NOK" {{ ($settings->currency ?? old('currency')) == 'NOK' ? 'selected' : '' }}>NOK - Norwegian Krone</option>
                                    <option value="DKK" {{ ($settings->currency ?? old('currency')) == 'DKK' ? 'selected' : '' }}>DKK - Danish Krone</option>
                                    <option value="PLN" {{ ($settings->currency ?? old('currency')) == 'PLN' ? 'selected' : '' }}>PLN - Polish Zloty</option>
                                    <option value="CZK" {{ ($settings->currency ?? old('currency')) == 'CZK' ? 'selected' : '' }}>CZK - Czech Koruna</option>
                                    <option value="HUF" {{ ($settings->currency ?? old('currency')) == 'HUF' ? 'selected' : '' }}>HUF - Hungarian Forint</option>
                                    <option value="RUB" {{ ($settings->currency ?? old('currency')) == 'RUB' ? 'selected' : '' }}>RUB - Russian Ruble</option>
                                    <option value="BRL" {{ ($settings->currency ?? old('currency')) == 'BRL' ? 'selected' : '' }}>BRL - Brazilian Real</option>
                                    <option value="MXN" {{ ($settings->currency ?? old('currency')) == 'MXN' ? 'selected' : '' }}>MXN - Mexican Peso</option>
                                    <option value="INR" {{ ($settings->currency ?? old('currency')) == 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                                    <option value="ZAR" {{ ($settings->currency ?? old('currency')) == 'ZAR' ? 'selected' : '' }}>ZAR - South African Rand</option>
                                    <option value="AED" {{ ($settings->currency ?? old('currency')) == 'AED' ? 'selected' : '' }}>AED - UAE Dirham</option>
                                    <option value="SAR" {{ ($settings->currency ?? old('currency')) == 'SAR' ? 'selected' : '' }}>SAR - Saudi Riyal</option>
                                    <option value="QAR" {{ ($settings->currency ?? old('currency')) == 'QAR' ? 'selected' : '' }}>QAR - Qatari Riyal</option>
                                    <option value="KWD" {{ ($settings->currency ?? old('currency')) == 'KWD' ? 'selected' : '' }}>KWD - Kuwaiti Dinar</option>
                                    <option value="BHD" {{ ($settings->currency ?? old('currency')) == 'BHD' ? 'selected' : '' }}>BHD - Bahraini Dinar</option>
                                    <option value="OMR" {{ ($settings->currency ?? old('currency')) == 'OMR' ? 'selected' : '' }}>OMR - Omani Rial</option>
                                    <option value="JOD" {{ ($settings->currency ?? old('currency')) == 'JOD' ? 'selected' : '' }}>JOD - Jordanian Dinar</option>
                                    <option value="LBP" {{ ($settings->currency ?? old('currency')) == 'LBP' ? 'selected' : '' }}>LBP - Lebanese Pound</option>
                                    <option value="EGP" {{ ($settings->currency ?? old('currency')) == 'EGP' ? 'selected' : '' }}>EGP - Egyptian Pound</option>
                                    <option value="TRY" {{ ($settings->currency ?? old('currency')) == 'TRY' ? 'selected' : '' }}>TRY - Turkish Lira</option>
                                    <option value="ILS" {{ ($settings->currency ?? old('currency')) == 'ILS' ? 'selected' : '' }}>ILS - Israeli Shekel</option>
                                    </select>
                                    @error('currency')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>
                            <div class="col-md-6">
                                <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if(isset($settings->logo))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$settings->logo) }}" alt="Store Logo" style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Settings') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection