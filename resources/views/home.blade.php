@extends('layout.master')
@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <!-- Doctor -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-md"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Doctor</span>
                                <span class="info-box-number">{{ $doctorCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Nurse -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-nurse"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Nurse</span>
                                <span class="info-box-number">{{ $nurseCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Patient -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-procedures"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Patient</span>
                                <span class="info-box-number">{{ $patientCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Customer</span>
                                <span class="info-box-number">{{ $customerCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Suppliers and Medicine Section -->
                <div class="row">
                    <!-- Suppliers -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-truck"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Suppliers</span>
                                <span class="info-box-number">{{ $supplierCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Add/Purchase Medicine -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-pills"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Purchase Medicine</span>
                                <span class="info-box-number">{{ $purchaseMedicineCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Medicine Sales -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-capsules"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Medicine Sales</span>
                                <span class="info-box-number">{{ $medicineSalesCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- All Medicines -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-dark elevation-1"><i class="fas fa-medkit"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">All Medicines</span>
                                <span class="info-box-number">{{ $totalMedicines ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Tests and Test Sales -->
                <div class="row">
                    <!-- Total Tests -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-vials"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Tests</span>
                                <span class="info-box-number">{{ $totalTests ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Test Sales -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-medical"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Test Sales</span>
                                <span class="info-box-number">{{ $testSalesCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
