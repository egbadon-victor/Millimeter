<?php
require_once('backend/header-admin.php');
include('./backend/sensor_values.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Millimeter | Dashboard</title>
		<link
			href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
			rel="stylesheet"
			integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
			crossorigin="anonymous"
		/>
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700&display=swap" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet" />
		<link rel="stylesheet" href="./css/loading-bar.min.css" />
		<link rel="stylesheet" href="./css/style.css" />
			<link rel="shortcut icon" href="img/millimeter favicon.png" type="image/x-icon">
	</head>
	<body style="background-color: #f2f3f4; color: #212741;">
		<header>
			<nav class="main-nav">
				<button class="hamburger-menu" onclick="openMenu()">
					<i class="fa fa-navicon"></i>
				</button>
				<div class="main-nav-items">
				<div class="millimeter-logo">
					<img src="./img/millimeter-logo.svg" alt="Millimeter logo" />
				</div>
				<ul id="main-nav-ul">
					<li>
						<span class="user-name">Alakra Ada</span>
						<img
							src="./img/suad-kamardeen-LmpGoHg0JBU-unsplash@2x.png"
							class="profile-pic"
							alt="profile picture"
						/><span><img src="./img/ic-arrow-drop-down-24px.svg" alt="drop down icon" /></span>
					</li>
					<li><img src="./img/ic-notifications-active-24px.svg" alt="notifications icon" /></li>
					<li><img src="./img/ic-settings-24px.svg" alt="settings icon" /></li>
				</ul>
				</div>
			</nav>
		</header>
		<div class="side-navbar" id="sideNavbar">
			<div class="side-navbar-ul">
				<ul>
					<li id="sideNavbarHome" class=" side-navbar-item side-navbar-active"><img src="./img/home.2.svg" alt="home icon" /> <span class="side-navbar-text">Home</span></li>
					<li id="sideNavbarProfile" class="side-navbar-item"><img src="./img/fingerprint-alt.2.svg" alt="profile icon" /> <span class="side-navbar-text">Profile</span></li>
					<li id="sideNavbarReporting" class="side-navbar-item"><img src="./img/analytics-alt.2.svg" alt="reporting icon" /><span class="side-navbar-text">Reporting</span></li>
					<li id="sideNavbarBilling" class="side-navbar-item"><img src="./img/money-bill-wave-alt.2.svg" alt="billing icon" /><span class="side-navbar-text">Billing</span></li>
					<li id="sideNavbarLogout"><a href="backend/logout.php"><img src="./img/sign-out-alt.2.svg" alt="log out" /><span class="side-navbar-text">Logout</span></a></li>
				</ul>
			</div>
		</div>

		<div id="overlay"></div>

		<div class="dashboard-section dashboard-home" id="dashboard-home">
			<div class="dashboard-home-section activity">
				<h2>Activity</h2>
				<ul class="activity-list">
					<li class="activity-list-item">
						<div class="activity-list-item-name">
							<img src="./img/money-bill-wave.3.svg" alt="list icon" />
							<div>
								<h3 style="font-weight: bold;">Energy Top Up</h3>
								<small>You recently bought 241.3Kw of energy</small>
							</div>
						</div>
						<div class="activity-list-item-amount">
							<p>N7,000</p>
							<small>03-03-2020</small>
						</div>
					</li>
					<li class="activity-list-item">
						<div class="activity-list-item-name">
							<img src="./img/bell-exclamation.3.svg" alt="list icon" />
							<div>
								<h3 style="font-weight: bold; color: #ff5119;">Energy Theft</h3>
								<small>We've detected a wire temper at your meter location</small>
							</div>
						</div>
						<div class="activity-list-item-amount">
							<p style="color: #ff5119;">Contact Us</p>
							<small>19-03-2020</small>
						</div>
					</li>
					<li class="activity-list-item">
						<div class="activity-list-item-name">
							<img src="./img/money-bill-wave.3.svg" alt="list icon" />
							<div>
								<h3 style="font-weight: bold;">Energy Top Up</h3>
								<small>You recently bought 241.3Kw of energy</small>
							</div>
						</div>
						<div class="activity-list-item-amount">
							<p>N7,000</p>
							<small>03-03-2020</small>
						</div>
					</li>
				</ul>
				<button class="view-all-btn" id="view-all-btn" onclick="openModal(activityModal)">VIEW ALL</button>
			</div>
			<div class="dashboard-home-section energy-left">
				<h2>Energy Left</h2>
				<small><?php echo $voltage_left; ?>Kwh of 987Kwh</small>
				<div class="ldBar label-center" data-value="<?php echo floor($voltage_percentage_left); ?>" data-preset="circle">
					<div class="ldBar-body"></div>
				</div>
			</div>
			<div class="dashboard-home-section energy-consumption">
				<h2>Energy Consumption</h2>
				<div class="chart1">
					<canvas id="energyConsumptionChart"></canvas>
				</div>
			</div>
		</div>

		<div class="dashboard-section dashboard-profile" id="dashboard-profile">
			<div class="dashboard-profile-container">
				<div class="dashboard-profile-section" id="profile-pic">
					<div>
						<div id="image-container">
							<img src="./img/suad-kamardeen-LmpGoHg0JBU-unsplash@2x.png" alt="profile-pic" />
							<div class="edit">
								<img src="./img/ic-edit-48px.svg" alt="edit" />
							</div>
						</div>
					</div>
					<h2>Alakra Ada</h2>
					<small>68990037890-0</small>
				</div>
				<div class="dashboard-profile-section" id="personal-info">
					<h2>Personal Information</h2>
					<form id="personal-info-form" action="#">
						<div class="input-group" id="fname-container">
							<label for="fname">First Name</label><br />
							<input type="text" name="fname" id="fname" value="Ada" />
						</div>
						<div class="input-group" id="lname-container">
							<label for="lname">Last Name</label><br />
							<input type="text" name="lname" id="lname" value="Alakra" />
						</div>
						<div class="input-group" id="email-container">
							<label for="email">E-mail</label><br />
							<input type="email" name="email" id="email" value="alakrada@sample.com" />
						</div>
						<div class="input-group" id="contact-container">
							<label for="">Contact No.</label><br />
							<input type="number" name="contactNo" id="contactNo" placeholder="Fill in Contact No." />
						</div>
						<div class="input-group" id="city-container">
							<label for="city">City</label><br />
							<input type="text" name="city" id="city" value="Lagos" />
						</div>
						<button class="personal-info-btn">UPDATE</button>
					</form>
				</div>
				<div class="dashboard-profile-section billing-info" id="billing-info">
					<h2>Billing Info</h2>
					<div class="billing-card">
						<div class="billing-card-img">
							<img class="atm-img" src="./img/Screenshot (280).png" alt="atm card image" />
						</div>
						<div class="billing-card-info">
							<div class="billing-card-info-container solid-border">
								<img class="icon" src="./img/Layer 2.svg" alt="mastercard icon" />
								<span class="main-p">Visa ending in 5678</span>
									<div class="placeholder"></div>
								<div class="edit-container">
									<small class="date">07/22</small>
									<span class="primary-color">Edit</span>
									<img class="trash" src="./img/trash-alt.3.svg" alt="trash icon" />
								</div>
							</div>
						</div>
					</div>
					<div class="billing-card">
						<div class="billing-card-img">
							<img  class="atm-img" src="./img/atmcard2.svg" alt="atm card image" />
						</div>
						<div class="billing-card-info">
							<div class="billing-card-info-container solid-border">
								<img class="icon" src="./img/Group 533.svg" alt="mastercard icon" />
								<span class="main-p">Visa ending in 5678</span>
								<div class="placeholder"></div>
								<div class="edit-container">
									<small class="date">07/22</small>
									<span class="primary-color">Edit</span>
									<img class="trash" src="./img/trash-alt.3.svg" alt="trash icon" />
								</div>
							</div>
						</div>
					</div>
					<div class="billing-card" id="add-payment">
						<div class="billing-card-img">
							<div class="add-payment-img">
							  <img src="./img/atmcardmini.svg" alt="atm card image" />
							</div>
						</div>
						<div class="billing-card-info">
							<div class="billing-card-info-container add-payment-container" onclick="openModal(addPaymentModal)">
								<img class="icon" src="./img/ic-add-circle-outline-24px.svg" alt="mastercard icon"  >
								<span class="main-p primary-color">Add Payment Method</span>
									<div class="placeholder"></div>
								<div class="edit-container >
									<small class="date">07/22</small>
									<span class="primary-color">Edit</span>
									<img class="trash" src="./img/trash-alt.3.svg" alt="trash icon" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="dashboard-section dashboard-reporting" id="dashboard-reporting">
			<div class="dashboard-profile-section energy-left">
				<h2>Energy Left</h2>
				<small>740.27Kwh of 987Kwh</small>
				<div class="ldBar label-center" data-value="75" data-preset="circle">
					<div class="ldBar-body"></div>
				</div>
			</div>
			<div class="dashboard-profile-section today">
				<h2>Today</h2>
				<div class="today-content">
					<p>
						<span class="figure">98.7 <sup>Kwh</sup></span>
					</p>
					<small>was used.</small>
				</div>
				<p class="primary-color amount">N2,862.3</p>
			</div>
			<div class="dashboard-profile-section energy-available mini-section">
				<h2 class="muted-heading">Energy Available</h2>
				<div class="row">
					<div class="col">
						<span class="source-sans">740.24Kwh</span><br />
						<small class="primary-color"><i class="fa fa-long-arrow-down mr-5"></i>25%</small>
					</div>
					<div class="col flex-end">
						<img class="barchart" src="./img/Bar Chart.svg" alt="barchart" />
					</div>
				</div>
			</div>
			<div class="dashboard-profile-section cost mini-section">
				<h2 class="muted-heading">Cost</h2>
				<div class="row">
					<div class="col">
						<span class="source-sans">N21,466.96</span><br />
						<small class="primary-color"><i class="fa fa-long-arrow-down mr-5"></i>25%</small>
					</div>
					<div class="col flex-end">
						<img class="barchart" src="./img/Bar Chart.svg" alt="barchart" />
					</div>
				</div>
			</div>
			<div class="dashboard-profile-section meter-condition mini-section">
				<h2 class="muted-heading">Meter Condition</h2>
				<div class="row">
					<div class="col">
						<span class="source-sans">ON</span><br />
						<small class="secondary-color">GOOD</small>
					</div>
					<div class="col flex-end">
						<button class="turn-off-btn">TURN OFF</button>
					</div>
				</div>
			</div>
			<div class="dashboard-profile-section refill-date mini-section">
				<h2 class="muted-heading">Projected Refill Date</h2>
				<div class="row">
					<div class="col">
						<span class="source-sans">29/03/2020</span><br />
						<small>Your energy usage is <br /><span class="secondary-color">EFFICIENT</span></small>
					</div>
					<div class="col flex-end">
						<button class="topup-btn" id="topupBtn" >TOP-UP</button>
					</div>
				</div>
			</div>
			<div class="dashboard-profile-section energy-consumption mini-section">
				<div class="chart2">
					<h2>Energy Consumption</h2>
					<canvas id="energyConsumptionChart2"></canvas>
				</div>
				</div>
			</div>
		</div>

		<div class="dashboard-section dashboard-billing" id="dashboard-billing">
			<div class="dashboard-billing-container">
				<div class="row flex block">
					<div class="dashboard-billing-section billing-info">
						<h2>Quick Top-up</h2>
						<h3>Select Payment Method</h3>
						<div class="billing-card">
							<div class="billing-card-img">
								<img class="atm-img" src="./img/Screenshot (280).png" alt="atm card image" />
							</div>
							<div class="billing-card-info">
								<div class="billing-card-info-container">
									<img class="icon" src="./img/Layer 2.svg" alt="mastercard icon" />
									<span class="main-p">Visa ending in 5678</span>
									<div></div>
									<div class="edit-container">
										<small class="date">07/22</small>
										<label class="checkbox-container">
											<input type="checkbox" name="paymentCard1" id="paymentCard1" />
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="billing-card">
							<div class="billing-card-img">
								<img class="atm-img" src="./img/atmcard2.svg" alt="atm card image" />
							</div>
							<div class="billing-card-info">
								<div class="billing-card-info-container">
									<img class="icon" src="./img/Group 533.svg" alt="visa icon" />
									<span class="main-p">Visa ending in 5678</span>
									<div></div>
									<div class="edit-container">
										<small class="date">07/22</small>
										<label class="checkbox-container">
											<input type="checkbox" name="paymentCard1" id="paymentCard1" />
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="dashboard-billing-section payment-history">
						<h2>Payment History</h2>

						<ul class="activity-list">
							<li class="activity-list-item">
								<div class="activity-list-item-name">
									<img src="./img/money-bill-wave.3.svg" alt="list icon" />
									<div>
										<h3 style="font-weight: bold;">Energy Top Up</h3>
									</div>
								</div>
								<div class="activity-list-item-amount">
									<p>N7,000</p>
									<small>03-03-2020</small>
								</div>
							</li>
							<li class="activity-list-item">
								<div class="activity-list-item-name">
									<img src="./img/money-bill-wave.3.svg" alt="list icon" />
									<div>
										<h3 style="font-weight: bold;">Energy Top Up</h3>
									</div>
								</div>
								<div class="activity-list-item-amount">
									<p>N7,000</p>
									<small>03-03-2020</small>
								</div>
							</li>
							<li class="activity-list-item">
								<div class="activity-list-item-name">
									<img src="./img/money-bill-wave.3.svg" alt="list icon" />
									<div>
										<h3 style="font-weight: bold;">Energy Top Up</h3>
									</div>
								</div>
								<div class="activity-list-item-amount">
									<p>N7,000</p>
									<small>03-03-2020</small>
								</div>
							</li>
						</ul>
						<button class="view-all-btn">VIEW ALL</button>
					</div>
				</div>
				<div class="row flex">
					<div class="dashboard-billing-section pay-section">
						<div class="form-container">
							<form action="#">
								<div class="row flex block-md">
									<div class="input-group col">
										<label for="amount">Amount</label><br />
										<input type="number" name="amount" id="amount" />
									</div>
									<div class="input-group col">
										<label for="amount">Milli Pin</label><br />
										<input type="password" name="milliPIn" id="milliPin" />
										<img class="lock-img" src="./img/lock-alt.2.svg" alt="" />
									</div>
								</div>
							</form>
						</div>
						<div class="payment">
							<small>N7,000</small><br />
							<button class="pay-btn">PAY</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="activity-modal">
			<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<h2>All Activity</h2>
					<button id="activity-modal-close"><img  src="./img/ic-add-48px.svg"  alt="close"></button>
				</div>
				<div class="modal-body">
					<ul class="activity-list">
						<li class="activity-list-item">
							<div class="activity-list-item-name">
								<img src="./img/money-bill-wave.3.svg" alt="list icon" />
								<div>
									<h3 style="font-weight: bold;">Energy Top Up</h3>
									<small>You recently bought 241.3Kw of energy</small>
								</div>
							</div>
							<div class="activity-list-item-amount">
								<p>N7,000</p>
								<small>03-03-2020</small>
							</div>
						</li>
						<li class="activity-list-item">
							<div class="activity-list-item-name">
								<img src="./img/bell-exclamation.3.svg" alt="list icon" />
								<div>
									<h3 style="font-weight: bold; color: #ff5119;">Energy Theft</h3>
									<small>We've detected a wire temper at your meter location</small>
								</div>
							</div>
							<div class="activity-list-item-amount">
								<p style="color: #ff5119;">Contact Us</p>
								<small>19-03-2020</small>
							</div>
						</li>
						<li class="activity-list-item">
							<div class="activity-list-item-name">
								<img src="./img/money-bill-wave.3.svg" alt="list icon" />
								<div>
									<h3 style="font-weight: bold;">Energy Top Up</h3>
									<small>You recently bought 241.3Kw of energy</small>
								</div>
							</div>
							<div class="activity-list-item-amount">
								<p>N7,000</p>
								<small>03-03-2020</small>
							</div>
						</li>
						<li class="activity-list-item">
							<div class="activity-list-item-name">
								<img src="./img/money-bill-wave.3.svg" alt="list icon" />
								<div>
									<h3 style="font-weight: bold;">Energy Top Up</h3>
									<small>You recently bought 186.21Kw of energy</small>
								</div>
							</div>
							<div class="activity-list-item-amount">
								<p>N5,400</p>
								<small>10-01-2020</small>
							</div>
						</li>
					</ul>
				</div>
			</div>
			</div>
		</div>

		<div class="modal" id="addPaymentModal">
			<div class="modal-container">
				<div class="modal-content">
					<div class="modal-header">
						<h2>Add Payment Method</h2>
						<button id="addPaymentModalClose"><img src="./img/ic-add-48px.svg" alt="close"></button>
					</div>
					<div class="modal-body">
						<div class="flex-col row credit-card-text-container">
							<div class="row flex">
								<div class="col credit-card-logo visa">
									<img src="./img/Group 533.svg" alt="visa">
								</div>
								<div class="col credit-card-logo mastercard">
									<img src="./img/Layer 3.svg" alt="mastercard">
								</div>
							</div>
							<div class="credit-card-text">
								<p>xLorizzle own yo’ dolor boom shackalack amizzle, consectetizzle adipiscing elit. Nullizzle sapien velizzle, yo mamma
								volutpat, suscipizzle quizzle, ass vizzle, nizzle. Pellentesque rizzle tortizzle. Sizzle erizzle. Fo shizzle izzle for
								sure dapibizzle turpis tempizzle for sure. Maurizzle fo shizzle nibh ma nizzle crazy. Hizzle in hizzle. Pellentesque
								eleifend rhoncizzle ma nizzle. In hac habitasse sizzle dictumst.</p>
							</div>
						</div>
						<form class="credit-card-form" action="#">
							<div class="input-group">
								<label for="cardholderName">CardHolder Name</label>
								<input type="text" name="cardholderName" id="cardholderName" placeholder="Name">
							</div>
							<div class="input-group">
								<label for="creditCardNumber">Credit Card Number</label>
								<input type="text" name="creditCardNumber" id="creditCardNumber" placeholder="Card Number">
							</div>
							<div class="flex row block-sm">
								<div class="input-group">
									<label for="expirationDate">Expiration Date</label>
									<input type="text" name="expirationDate" id="expirationDate" placeholder="MM">
								</div>
								<div class="input-group">
									<label class="exp-year-label"  for="expirationYear">Year</label>
									<input type="text" name="expirationYear" id="expirationYear" placeholder="YYYY">
								</div>
								<div class="input-group">
									<label for="cvv">CVV</label>
									<input type="text" name="cvv" id="cvv" placeholder="CVV">
								</div>
							</div>
							<div class="flex-center row">
								<p><img src="./img/lock-alt.2.svg" alt="">Your current information is encrypted</p>
							</div>
							<div class="flex-center row">
								<button class="cancel-btn ">CANCEL</button>
								<button class="add-btn">ADD</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<script src="./js/loading-bar.min.js"></script>
		<script src="./js/chartjs.min.js"></script>
		<script src="./js/app.js"></script>
		<?php include("./js/app.php"); ?>
		
	</body>
</html>
