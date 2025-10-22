@extends('layouts.app_so_query')

<style>
    /* Mengatur font dan background untuk tampilan keseluruhan */
    .so-info-container {
        font-family: futura-lt-w01-book, sans-serif;
        /*background-color: #212529;*/
        color: white;
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Mengatur container utama dengan lebar maksimal dan di tengah */
    .main-card {
        max-width: 800px;
        margin: auto;
        padding: 0 15px;
    }

    /* === Perbaikan untuk Info & Footer Section === */
    .info-section h2, .footer-section h4 {
        font-size: 1.5rem;
        margin: 0;
    }

    .info-item, .footer-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .info-label, .footer-label {
        flex-basis: 180px;
        flex-shrink: 0;
        text-align: left;
    }

    .info-separator, .footer-separator {
        flex-basis: 20px;
        flex-shrink: 0;
        text-align: center;
    }

    .info-value, .footer-value {
        flex-grow: 1;
        text-align: left;
    }

    /* === Perbaikan untuk Training & Skills Section === */
    .header-section {
        background-color: white;
        color: black;
        text-align: center;
        padding: 0.5rem;
    }

    .training-header {
        margin-top: 1rem;
        margin-bottom: 1.5rem;
    }

    .skills-header {
        margin-top: 2rem;
        margin-bottom: 1.5rem;
    }

    .training-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .training-logo-box {
        width: 150px;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: white;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }

    .training-logo-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .training-text h2 {
        font-size: 1.2rem;
        line-height: 1.2;
        margin: 0;
    }

    .skills-item {
        margin-bottom: 0.5rem;
    }

    .skills-item h2 {
        font-size: 1.5rem;
    }

    .footer-section {
        margin-top: 2rem;
    }

    .footer-section h4 {
        font-weight: normal;
        font-size: 1rem;
        line-height: 1.5;
    }

    /* === Perbaikan Responsivitas untuk HP === */
    @media (max-width: 575.98px) {
        .so-info-container {
            padding: 1rem;
        }

        .main-card {
            padding: 0;
        }

        /* Mengatur ulang font dan tata letak untuk layar kecil */
        .info-section h2, .footer-section h4 {
            font-size: 0.8rem; /* Ukuran font lebih kecil agar muat */
            line-height: 1.2;
        }

        .training-text h2 {
            font-size: 0.9rem;
        }

        /* Mengatur kembali flexbox untuk tampilan horizontal */
        .info-item, .footer-item {
            flex-wrap: wrap;
            align-items: flex-start;
            margin-bottom: 0; /* Hapus margin agar baris lebih rapat */
        }

        .info-label, .footer-label {
            flex-basis: 90px; /* Atur lebar tetap yang lebih kecil untuk label */
            flex-shrink: 0;
            text-align: left;
            margin-bottom: 0;
        }

        .info-separator, .footer-separator {
            flex-basis: 10px;
            flex-shrink: 0;
            text-align: left;
            margin-bottom: 0;
        }

        .info-value, .footer-value {
            flex-grow: 1;
            text-align: left;
            margin-bottom: 0.5rem; /* Jarak antar baris info */
            line-height: 1.2;
        }

        .training-item {
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .training-logo-box {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }

        .training-text {
            text-align: center;
        }
    }
</style>

@section('content')
    <div class="so-info-container">
        <div class="main-card">
            {{-- Header: SECURITY OFFICER'S INFO --}}
            <h1 class="text-white text-center mb-4"><b>SECURITY OFFICER'S INFO</b></h1>

            {{-- Section: Info Pribadi --}}
            <div class="info-section mb-5">
                <div class="info-item">
                    <div class="info-label"><h2><b>NAME</b></h2></div>
                    <div class="info-separator"><h2><b>:</b></h2></div>
                    <div class="info-value"><h2>{{$soquery->Name}}</h2></div>
                </div>
                <div class="info-item">
                    <div class="info-label"><h2><b>PASS ID</b></h2></div>
                    <div class="info-separator"><h2><b>:</b></h2></div>
                    <div class="info-value"><h2>{{$soquery->PassID}}</h2></div>
                </div>
                <div class="info-item">
                    <div class="info-label"><h2><b>PWM GRADE</b></h2></div>
                    <div class="info-separator"><h2><b>:</b></h2></div>
                    <div class="info-value"><h2>{{$soquery->Grade}}</h2></div>
                </div>
                <div class="info-item">
                    <div class="info-label"><h2><b>LICENSE EXPIRY</b></h2></div>
                    <div class="info-separator"><h2><b>:</b></h2></div>
                    <div class="info-value"><h2>{{date('d/m/Y ',strtotime($soquery->LicenseExpiryDate))}}</h2></div>
                </div>
            </div>

            {{-- Header: TRAINING COMPETENCY --}}
            <div class="header-section training-header">
                <h1><b>TRAINING COMPETENCY</b></h1>
            </div>
            <div class="row">

                @if($soquery->TR_CCTC == "YES")
                    <div class="col-12">
                        <div class="training-item">
                            <div class="training-logo-box">
                                <img src="{{URL::asset('/img/logo/Logo_1.jpg')}}" alt="CCTC Logo">
                            </div>
                            <div class="training-text">
                                <h2>CCTC<br>Conduct Crowd and Traffic Control</h2>
                            </div>
                        </div>
                    </div>
                @endif
                @if($soquery->TR_CSSPB == "YES")
                    <div class="col-12">
                        <div class="training-item">
                            <div class="training-logo-box">
                                <img src="{{URL::asset('/img/logo/Logo_2.jpg')}}" alt="CCTC Logo">
                            </div>
                            <div class="training-text">
                                <h2>CSS-P/B<br>Conduct Security Screening of Person and Bag</h2>
                            </div>
                        </div>
                    </div>
                @endif
                @if($soquery->TR_X_RAY == "YES")
                    <div class="col-12">
                        <div class="training-item">
                            <div class="training-logo-box">
                                <img src="{{URL::asset('/img/logo/Logo_3.jpg')}}" alt="CCTC Logo">
                            </div>
                            <div class="training-text">
                                <h2>CSS-X<br>Conduct Security Screening using X-ray Machine</h2>
                            </div>
                        </div>
                    </div>
                @endif
                @if($soquery->TR_HCTA == "YES")
                    <div class="col-12">
                        <div class="training-item">
                            <div class="training-logo-box">
                                <img src="{{URL::asset('/img/logo/Logo_4.jpg')}}" alt="RTT Logo">
                            </div>
                            <div class="training-text">
                                <h2>HCTA<br>Handle Counter Terrorism Activities</h2>
                            </div>
                        </div>
                    </div>
                @endif
                @if($soquery->TR_RTT == "YES")
                    <div class="col-12">
                        <div class="training-item">
                            <div class="training-logo-box">
                                <img src="{{URL::asset('/img/logo/Logo_5.jpg')}}" alt="RTT Logo">
                            </div>
                            <div class="training-text">
                                <h2>RTT<br>Recognise Terrorist Threats</h2>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Header: SKILL SETS ACQUIRED --}}
            @if(
                 $soquery->SKILL_BFM == "YES" ||
                 $soquery->SKILL_BSS == "YES" ||
                 $soquery->SKILL_FSM == "YES" ||
                 $soquery->SKILL_CERT == "YES" ||
                 $soquery->SKILL_COSEM == "YES"
             )
                <div class="header-section skills-header">
                    <h1><b>SKILL SETS ACQUIRED</b></h1>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if($soquery->SKILL_BFM == "YES")
                            <div class="skills-item"><h2><b>Basic Facilities Management</b></h2></div>
                        @endif
                        @if($soquery->SKILL_BSS == "YES")
                            <div class="skills-item"><h2><b>Fundamentals of Building Services & Safety</b></h2></div>
                        @endif
                        @if($soquery->SKILL_FSM == "YES")
                            <div class="skills-item"><h2><b>Fire Safety Management</b></h2></div>
                        @endif
                        @if($soquery->SKILL_CERT == "YES")
                            <div class="skills-item"><h2><b>CERT</b></h2></div>
                        @endif
                        @if($soquery->SKILL_COSEM == "YES")
                            <div class="skills-item"><h2><b>COSEM</b></h2></div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Footer: Information Updated As Of --}}
            <div class="row footer-section">
                <div class="col-12">
                    <div class="footer-item">
                        <div class="footer-label"><h4><b>Information Updated As Of</b></h4></div>
                        <div class="footer-separator"><h4><b>:</b></h4></div>
                        <div class="footer-value"><h4>{{date('d F Y ',strtotime($soquery->Date_Submitted))}}</h4></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
