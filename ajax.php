<?php
require ('mysqli_connect.php');

switch ($_POST['action']){

    case 'get_full_data':

    $json = ['message'=>'', 'success'=>0];
    
    $days = "SELECT member_id AS id, COUNT(member_id) AS days_present FROM member_days WHERE MONTH(class_day) = MONTH(CURDATE()) GROUP BY member_id";		
    $r1 = @mysqli_query ($dbc, $days); 
    if ($r1) {
        while ($row = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
            $json['member_days'][] = $row;
        }
    } else { 
        $json['message'] = 'Error getting member data.';
        $json['debug'] = mysqli_error($dbc) . '<br /><br />Query: ' . $days;           
    }
    
    $payments = "SELECT member_id AS id, SUM(payment_amount) AS amount_paid FROM payments WHERE MONTH(payment_date) = MONTH(CURDATE()) GROUP BY member_id";		
    $r2 = @mysqli_query ($dbc, $payments); 
    if ($r2) {
        while ($row = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
            $json['member_payment'][] = $row;
        }
    } else { 
        $json['message'] = 'Error getting member data.';
        $json['debug'] = mysqli_error($dbc) . '<br /><br />Query: ' . $payments;           
    }

    echo json_encode($json);

    break;

    
    
    case 'new_member':
    
    $json = ['message'=>'', 'success'=>0];
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));

    $q = "INSERT INTO members(first_name, last_name) VALUES ('$first_name', '$last_name')";		
    $r = @mysqli_query ($dbc, $q);
    if ($r) {
        $json['success'] = 1;
        $json['message'] = 'User Added'; 
    } else { 
        $json['message'] = 'Failed to add user.';
        
        $json['debug'] = mysqli_error($dbc) . '<br /><br />Query: ' . $q;           
    }
    echo json_encode($json);

    break;

    case 'attendance': 

    $json = ['message'=>'', 'success'=>0];

    $ids = '(' . implode('), (', $_POST['todays_members']) . ')';
    
    $q = "INSERT INTO member_days(member_id) VALUES ". $ids;		
    $r = @mysqli_query ($dbc, $q); 
    if ($r) {
        $json['success'] = 1;
        $json['message'] = 'Attendance Saved.';
    } else { 
        $json['message'] = 'Error saving attendance data.';
        $json['debug'] = mysqli_error($dbc) . '<br /><br />Query: ' . $q;           
    }
    echo json_encode($json);

    break;

    case 'payment':
    $json = ['message'=>'', 'success'=>0];
    
    $member_id = mysqli_real_escape_string($dbc, trim($_POST['member']));
    $amt_paid = mysqli_real_escape_string($dbc, trim($_POST['amount']));

    $q = "INSERT INTO payments(member_id, payment_amount) VALUES ('$member_id', '$amt_paid')";		
    $r = @mysqli_query ($dbc, $q);
    if ($r) {
        $json['success'] = 1;
        $json['message'] = 'Payment added'; 
    } else { 
        $json['message'] = 'Failed to add payment.';
        
        $json['debug'] = mysqli_error($dbc) . '<br /><br />Query: ' . $q;           
    }

    echo json_encode($json);
    break;
}
mysqli_close($dbc);
?>