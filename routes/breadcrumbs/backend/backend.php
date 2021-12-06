<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';

//Employee CRUD
Breadcrumbs::for('employee.index', function ($trail) {
    $trail->push(__('strings.backend.employee.employee'), route('employee.index'));
});

Breadcrumbs::for('employee.create', function ($trail) {
    $trail->parent('employee.index');
    $trail->push(__('strings.backend.employee.create'), route('employee.create'));
});

Breadcrumbs::for('employee.edit', function ($trail, $id) {
    $trail->parent('employee.index');
    $trail->push(__('menus.backend.access.users.edit'), route('employee.edit', $id));
});

Breadcrumbs::for('employee.uploadExcelForm', function ($trail) {
    $trail->parent('employee.index');
    $trail->push(__('strings.backend.employee.uploadExcel'), route('employee.uploadExcelForm'));
});

//Experience CRUD
Breadcrumbs::for('experience.index', function ($trail) {
    $trail->push(__('strings.backend.employee.experience'), route('experience.index'));
});

Breadcrumbs::for('experience.create', function ($trail) {
    $trail->parent('experience.index');
    $trail->push(__('strings.backend.employee.create'), route('experience.create'));
});

Breadcrumbs::for('experience.edit', function ($trail, $id) {
    $trail->parent('experience.index');
    $trail->push(__('menus.backend.access.users.edit'), route('experience.edit', $id));
});

//Career CRUD
Breadcrumbs::for('career.index', function ($trail) {
    $trail->push(__('strings.backend.employee.career'), route('career.index'));
});

Breadcrumbs::for('career.create', function ($trail) {
    $trail->parent('career.index');
    $trail->push(__('strings.backend.employee.create'), route('career.create'));
});

Breadcrumbs::for('career.edit', function ($trail, $id) {
    $trail->parent('career.index');
    $trail->push(__('menus.backend.access.users.edit'), route('career.edit', $id));
});

//Education CRUD
Breadcrumbs::for('education.index', function ($trail) {
    $trail->push(__('strings.backend.employee.education'), route('education.index'));
});

Breadcrumbs::for('education.create', function ($trail) {
    $trail->parent('education.index');
    $trail->push(__('strings.backend.employee.create'), route('education.create'));
});

Breadcrumbs::for('education.edit', function ($trail, $id) {
    $trail->parent('education.index');
    $trail->push(__('menus.backend.access.users.edit'), route('education.edit', $id));
});

//Training CRUD
Breadcrumbs::for('training.index', function ($trail) {
    $trail->push(__('strings.backend.employee.training'), route('training.index'));
});

Breadcrumbs::for('training.create', function ($trail) {
    $trail->parent('training.index');
    $trail->push(__('strings.backend.employee.create'), route('training.create'));
});

Breadcrumbs::for('training.edit', function ($trail, $id) {
    $trail->parent('training.index');
    $trail->push(__('menus.backend.access.users.edit'), route('training.edit', $id));
});

//Miscellaneous CRUD
Breadcrumbs::for('miscz.index', function ($trail) {
    $trail->push(__('strings.backend.employee.misc'), route('miscz.index'));
});

Breadcrumbs::for('miscz.create', function ($trail) {
    $trail->parent('miscz.index');
    $trail->push(__('strings.backend.employee.create'), route('miscz.create'));
});

Breadcrumbs::for('miscz.edit', function ($trail, $id) {
    $trail->parent('miscz.index');
    $trail->push(__('menus.backend.access.users.edit'), route('miscz.edit', $id));
});

//Document CRUD
Breadcrumbs::for('document.index', function ($trail) {
    $trail->push(__('strings.backend.employee.document'), route('document.index'));
});

Breadcrumbs::for('document.create', function ($trail) {
    $trail->parent('document.index');
    $trail->push(__('strings.backend.employee.create'), route('document.create'));
});

Breadcrumbs::for('document.edit', function ($trail, $id) {
    $trail->parent('document.index');
    $trail->push(__('menus.backend.access.users.edit'), route('document.edit', $id));
});

//travel dashboard
Breadcrumbs::for('dashboard.index', function ($trail) {
    $trail->push(__('strings.backend.dashboard.index'), route('dashboard.index'));
});

// TRAVEL MANAGEMENT BEGIN

//TravelAgency crud
Breadcrumbs::for('travel.index', function ($trail) {
    $trail->push(__('strings.backend.travel.travelagency'), route('travel.index'));
});

Breadcrumbs::for('travel.create', function ($trail) {
    $trail->parent('travel.index');
    $trail->push(__('strings.backend.travel.create'), route('travel.create'));
});

Breadcrumbs::for('travel.edit', function ($trail, $id) {
    $trail->parent('travel.index');
    $trail->push(__('menus.backend.access.users.edit'), route('travel.edit', $id));
});

//PCC Crud
Breadcrumbs::for('pcc.index', function ($trail) {
    $trail->push(__('strings.backend.travel.pcc'), route('pcc.index'));
});

Breadcrumbs::for('pcc.create', function ($trail) {
    $trail->parent('pcc.index');
    $trail->push(__('strings.backend.travel.create'), route('pcc.create'));
});

Breadcrumbs::for('pcc.edit', function ($trail, $id) {
    $trail->parent('pcc.index');
    $trail->push(__('menus.backend.access.users.edit'), route('pcc.edit', $id));
});
//Miscellaneous CRUD
Breadcrumbs::for('travelmiscz.index', function ($trail) {
    $trail->push(__('strings.backend.travel.misc'), route('travelmiscz.index'));
});

Breadcrumbs::for('travelmiscz.create', function ($trail) {
    $trail->parent('miscz.index');
    $trail->push(__('strings.backend.travel.create'), route('travelmiscz.create'));
});

Breadcrumbs::for('travelmiscz.edit', function ($trail, $id) {
    $trail->parent('miscz.index');
    $trail->push(__('menus.backend.access.users.edit'), route('travelmiscz.edit', $id));
});
//Visit CRUD
Breadcrumbs::for('visit.index', function ($trail) {
    $trail->push(__('strings.backend.travel.visit'), route('visit.index'));
});

Breadcrumbs::for('visit.create', function ($trail) {
    $trail->parent('visit.index');
    $trail->push(__('strings.backend.travel.create'), route('visit.create'));
});

Breadcrumbs::for('visit.edit', function ($trail, $id) {
    $trail->parent('visit.index');
    $trail->push(__('menus.backend.access.users.edit'), route('visit.edit', $id));
});

//Staff crud
Breadcrumbs::for('staff.index', function ($trail) {
    $trail->push(__('strings.backend.travel.staff'), route('staff.index'));
});

Breadcrumbs::for('staff.create', function ($trail) {
    $trail->parent('staff.index');
    $trail->push(__('strings.backend.travel.create'), route('staff.create'));
});

Breadcrumbs::for('staff.edit', function ($trail, $id) {
    $trail->parent('staff.index');
    $trail->push(__('menus.backend.access.users.edit'), route('staff.edit', $id));
});

//Training Staff Crud
Breadcrumbs::for('trainingstaff.index', function ($trail) {
    $trail->push(__('strings.backend.travel.trainingstaff'), route('trainingstaff.index'));
});

Breadcrumbs::for('trainingstaff.create', function ($trail) {
    $trail->parent('trainingstaff.index');
    $trail->push(__('strings.backend.travel.create'), route('trainingstaff.create'));
});

Breadcrumbs::for('trainingstaff.edit', function ($trail, $id) {
    $trail->parent('trainingstaff.index');
    $trail->push(__('menus.backend.access.users.edit'), route('trainingstaff.edit', $id));
});

//LNIATA Crud
Breadcrumbs::for('lniata.index', function ($trail) {
    $trail->push(__('strings.backend.travel.lniata'), route('lniata.index'));
});

Breadcrumbs::for('lniata.create', function ($trail) {
    $trail->parent('lniata.index');
    $trail->push(__('strings.backend.travel.create'), route('lniata.create'));
});

Breadcrumbs::for('lniata.edit', function ($trail, $id) {
    $trail->parent('lniata.index');
    $trail->push(__('menus.backend.access.users.edit'), route('lniata.edit', $id));
});

//ACCOUNT MANAGER Crud
Breadcrumbs::for('accountmanager.index', function ($trail) {
    $trail->push(__('strings.backend.travel.accountmanager'), route('accountmanager.index'));
});

Breadcrumbs::for('accountmanager.create', function ($trail) {
    $trail->parent('accountmanager.index');
    $trail->push(__('strings.backend.travel.create'), route('accountmanager.create'));
});

Breadcrumbs::for('accountmanager.edit', function ($trail, $id) {
    $trail->parent('accountmanager.index');
    $trail->push(__('menus.backend.access.users.edit'), route('accountmanager.edit', $id));
});

//travel dashboard
Breadcrumbs::for('traveldashboard.index', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('traveldashboard.index'));
});


// AIRLINES MANAGEMENT BEGIN

//Airlines crud
Breadcrumbs::for('airlines.index', function ($trail) {
    $trail->push(__('strings.backend.airlines.airlines'), route('airlines.index'));
});

Breadcrumbs::for('airlines.create', function ($trail) {
    $trail->parent('airlines.index');
    $trail->push(__('strings.backend.airlines.create'), route('airlines.create'));
});

Breadcrumbs::for('airlines.edit', function ($trail, $id) {
    $trail->parent('airlines.index');
    $trail->push(__('menus.backend.access.users.edit'), route('airlines.edit', $id));
});

//AirlinesStaff Crud
Breadcrumbs::for('airlinesstaff.index', function ($trail) {
    $trail->push(__('strings.backend.airlines.airlines'), route('airlinesstaff.index'));
});

Breadcrumbs::for('airlinesstaff.create', function ($trail) {
    $trail->parent('airlines.index');
    $trail->push(__('strings.backend.airlines.create'), route('airlinesstaff.create'));
});

Breadcrumbs::for('airlinesstaff.edit', function ($trail, $id) {
    $trail->parent('airlines.index');
    $trail->push(__('menus.backend.access.users.edit'), route('airlinesstaff.edit', $id));
});

//AirlinesVisit Crud
Breadcrumbs::for('airlinesvisit.index', function ($trail) {
    $trail->push(__('strings.backend.airlines.airlines'), route('airlinesvisit.index'));
});

Breadcrumbs::for('airlinesvisit.create', function ($trail) {
    $trail->parent('airlines.index');
    $trail->push(__('strings.backend.airlines.create'), route('airlinesvisit.create'));
});

Breadcrumbs::for('airlinesvisit.edit', function ($trail, $id) {
    $trail->parent('airlines.index');
    $trail->push(__('menus.backend.access.users.edit'), route('airlinesvisit.edit', $id));
});

//AirlinesMisc Crud
Breadcrumbs::for('airlinesmisc.index', function ($trail) {
    $trail->push(__('strings.backend.airlines.airlines'), route('airlinesmisc.index'));
});

Breadcrumbs::for('airlinesmisc.create', function ($trail) {
    $trail->parent('airlines.index');
    $trail->push(__('strings.backend.airlines.create'), route('airlinesmisc.create'));
});

Breadcrumbs::for('airlinesmisc.edit', function ($trail, $id) {
    $trail->parent('airlines.index');
    $trail->push(__('menus.backend.access.users.edit'), route('airlinesmisc.edit', $id));
});

//airlines dashboard
Breadcrumbs::for('airlinesdashboard.index', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('airlinesdashboard.index'));
});

//Booking Crud
Breadcrumbs::for('booking.index', function ($trail) {
    $trail->push(__('strings.backend.booking.booking'), route('booking.index'));
});
    //MIDI
    Breadcrumbs::for('booking.uploadExcelForm', function ($trail) {
        $trail->parent('booking.index');
        $trail->push(__('strings.backend.booking.upload'), route('booking.uploadExcelForm'));
    });


//Revenue Crud
Breadcrumbs::for('revenue.index', function ($trail) {
    $trail->push(__('strings.backend.booking.revenue'), route('revenue.index'));
});
//revenue
Breadcrumbs::for('revenue.uploadExcelForm', function ($trail) {
    $trail->parent('revenue.index');
    $trail->push(__('strings.backend.booking.upload'), route('revenue.uploadExcelForm'));
});

//Incentive Crud
Breadcrumbs::for('incentive.index', function ($trail) {
    $trail->push(__('strings.backend.booking.incentive'), route('incentive.index'));
});
//Incentive
Breadcrumbs::for('incentive.uploadExcelForm', function ($trail) {
    $trail->parent('incentive.index');
    $trail->push(__('strings.backend.booking.upload'), route('incentive.uploadExcelForm'));
});




// ACCOUNT MANAGEMENT BEGIN

//Account Manager crud
Breadcrumbs::for('accounts.index', function ($trail) {
    $trail->push(__('strings.backend.accounts.accountmanager'), route('accounts.index'));
});

Breadcrumbs::for('accounts.create', function ($trail) {
    $trail->parent('accounts.index');
    $trail->push(__('strings.backend.accounts.create'), route('accounts.create'));
});

Breadcrumbs::for('accounts.edit', function ($trail, $id) {
    $trail->parent('accounts.index');
    $trail->push(__('menus.backend.access.users.edit'), route('accounts.edit', $id));
});

//account dashboard
Breadcrumbs::for('accountdashboard.index', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('accountdashboard.index'));
});

Breadcrumbs::for('accountdashboard.viewdetails', function ($trail) {
    $trail->push(__('strings.backend.dashboard.viewdetails'), route('accountdashboard.viewdetails'));
});


//Agency Agreement crud
Breadcrumbs::for('agencyagreement.index', function ($trail) {
    $trail->push(__('strings.backend.accounts.agencyagreement'), route('accounts.index'));
});

Breadcrumbs::for('agencyagreement.create', function ($trail) {
    $trail->parent('agencyagreement.index');
    $trail->push(__('strings.backend.agencyagreement.create'), route('agencyagreement.create'));
});

Breadcrumbs::for('agencyagreement.edit', function ($trail, $id) {
    $trail->parent('agencyagreement.index');
    $trail->push(__('menus.backend.access.users.edit'), route('agencyagreement.edit', $id));
});

//Incentive Data crud
Breadcrumbs::for('incentivedata.index', function ($trail) {
    $trail->push(__('strings.backend.accounts.incentivedata'), route('incentivedata.index'));
});

Breadcrumbs::for('incentivedata.create', function ($trail) {
    $trail->parent('incentivedata.index');
    $trail->push(__('strings.backend.incentivedata.create'), route('incentivedata.create'));
});

Breadcrumbs::for('incentivedata.edit', function ($trail, $id) {
    $trail->parent('incentivedata.index');
    $trail->push(__('menus.backend.access.users.edit'), route('incentivedata.edit', $id));
});

//Landing Page crud
Breadcrumbs::for('landing.index', function ($trail) {
    $trail->push(__('strings.backend.landing.index'), route('landing.index'));
});


// PRODUCT MANAGEMENT BEGIN

//Product Description crud
Breadcrumbs::for('products.index', function ($trail) {
    $trail->push(__('strings.backend.products.productdescription'), route('products.index'));
});

Breadcrumbs::for('products.create', function ($trail) {
    $trail->parent('products.index');
    $trail->push(__('strings.backend.products.create'), route('products.create'));
});

Breadcrumbs::for('products.edit', function ($trail, $id) {
    $trail->parent('products.index');
    $trail->push(__('menus.backend.access.users.edit'), route('products.edit', $id));
});

//Product Agreement crud
Breadcrumbs::for('productsagreement.index', function ($trail) {
    $trail->push(__('strings.backend.products.productsagreement'), route('productsagreement.index'));
});

Breadcrumbs::for('productsagreement.create', function ($trail) {
    $trail->parent('productsagreement.index');
    $trail->push(__('strings.backend.productsagreement.create'), route('productsagreement.create'));
});

Breadcrumbs::for('productsagreement.edit', function ($trail, $id) {
    $trail->parent('productsagreement.index');
    $trail->push(__('menus.backend.access.users.edit'), route('productsagreement.edit', $id));
});

//Product Cost Entry crud
Breadcrumbs::for('productscostentry.index', function ($trail) {
    $trail->push(__('strings.backend.products.productscostentry'), route('productscostentry.index'));
});

Breadcrumbs::for('productscostentry.create', function ($trail) {
    $trail->parent('productscostentry.index');
    $trail->push(__('strings.backend.productscost.create'), route('productscostentry.create'));
});

Breadcrumbs::for('productscostentry.edit', function ($trail, $id) {
    $trail->parent('productscostentry.index');
    $trail->push(__('menus.backend.access.users.edit'), route('productscostentry.edit', $id));
});

//Product Cost crud
Breadcrumbs::for('productscost.index', function ($trail) {
    $trail->push(__('strings.backend.products.productscost'), route('productscost.index'));
});

Breadcrumbs::for('productscost.create', function ($trail) {
    $trail->parent('productscost.index');
    $trail->push(__('strings.backend.productscost.create'), route('productscost.create'));
});

Breadcrumbs::for('productscost.edit', function ($trail, $id) {
    $trail->parent('productscost.index');
    $trail->push(__('menus.backend.access.users.edit'), route('productscost.edit', $id));
});

//product dashboard
Breadcrumbs::for('productdashboard.index', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('productdashboard.index'));
});


// Sales MANAGEMENT BEGIN

//Sales crud
Breadcrumbs::for('sales.index', function ($trail) {
    $trail->push(__('strings.backend.sales.sales'), route('sales.index'));
});

Breadcrumbs::for('sales.create', function ($trail) {
    $trail->parent('sales.index');
    $trail->push(__('strings.backend.sales.create'), route('sales.create'));
});

Breadcrumbs::for('sales.edit', function ($trail, $id) {
    $trail->parent('sales.index');
    $trail->push(__('menus.backend.access.users.edit'), route('sales.edit', $id));
});

Breadcrumbs::for('sales.daterange', function ($trail, $id) {
    $trail->parent('sales.index');
    $trail->push(__('menus.backend.access.users.daterange'), route('sales.daterange', $id));
});

//Sma Prize crud
Breadcrumbs::for('smaprize.index', function ($trail) {
    $trail->push(__('strings.backend.sales.smaprize'), route('smaprize.index'));
});

Breadcrumbs::for('smaprize.create', function ($trail) {
    $trail->parent('smaprize.index');
    $trail->push(__('strings.backend.smaprize.create'), route('smaprize.create'));
});

Breadcrumbs::for('smaprize.edit', function ($trail, $id) {
    $trail->parent('smaprize.index');
    $trail->push(__('menus.backend.access.users.edit'), route('smaprize.edit', $id));
});

//Sma other costs crud
Breadcrumbs::for('smaothercost.index', function ($trail) {
    $trail->push(__('strings.backend.sales.smaothercost'), route('smaothercost.index'));
});

Breadcrumbs::for('smaothercost.create', function ($trail) {
    $trail->parent('smaothercost.index');
    $trail->push(__('strings.backend.smaothercost.create'), route('smaothercost.create'));
});

Breadcrumbs::for('smaothercost.edit', function ($trail, $id) {
    $trail->parent('smaothercost.index');
    $trail->push(__('menus.backend.access.users.edit'), route('smaothercost.edit', $id));
});

//sma dashboard
Breadcrumbs::for('smadashboard.index', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('smadashboard.index'));
});
