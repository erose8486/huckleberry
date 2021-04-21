<!DOCTYPE html>
<head>
	<title>Tzurty's Gym</title>	
	<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
    <script src="script.js"></script>

</head>
<body>
<div id="ajax_message"></div>
<h3><button onclick="$('#new_member').slideDown()">&plus; New Member</button></h3>
<form id="new_member">
<button type="button" class="close" onclick="$('#new_member').slideUp()">&times;</button>
<br><input type="hidden" name="action" value="new_member">
<label for="first_name">First Name*: </label><input type="text" name="first_name" id="first_name" required>
<br><label for="last_name">Last Name: </label><input type="text" name="last_name" id="last_name">
<br><button type="submit">Add</button>
</form>

<form id="attendance">
<fieldset>
<legend id="todays-date"></legend>
<input type="hidden" name="action" value="attendance">
<div data-bind="foreach: members">
<input type="checkbox" name="todays_members[]" data-bind="value: id, attr: {id: id}"><label data-bind="attr: {for: id}"><!--ko text: first_name--><!--/ko--> <!--ko text: last_name--><!--/ko--></label>
<br><br></div>
<button type="submit">Done</button>
</fieldset>
</form>

<h3>Payment: </h3>
<form id="payment_form">
<input type="hidden" name="action" value="payment">
<label for="member-select">Member: </label><select name="member" id="member-select"  data-bind="options: members, optionsText: 'first_name', optionsValue: 'id', optionsCaption: 'Choose Member...'" required></select>
<label for="amt">Amount Paid: </label>$<input type="text" name="amount" id="amt" required>
<button type="submit">Pay</button>
</form>
<!--<h3>Previous Date: </h3>
<input type="date" name="date" id="prev-date">-->
<h3><span id="month"></span> Member Data</h3>
<table>
    <thead><th>Name</th><th>Days Present</th><th>Amount Paid</th></thead>
    <tbody data-bind="foreach: memberData">
        <td data-bind="text: fullName"></td>
        <td data-bind="text: daysPresent"></td>
        <td data-bind="text: paid"></td>
    </tbody>
</table>

</body>
</html>