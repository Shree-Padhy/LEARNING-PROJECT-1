<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include_once "../init.php";

    //User login check
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }

    include_once 'skeleton.php'; 
    
    if (isset($_SESSION['swal']))
    {
        echo $_SESSION['swal'];
        unset($_SESSION['swal']);
    }

    // Budget validity checker 
    $budget_validity = $getFromB->budget_validity_checker($_SESSION['UserId']);
    if($budget_validity == false)
    {
        $getFromB->del_budget_record($_SESSION['UserId']);
    }

    // Today's Expenses
    $today_expense = $getFromE->Expenses($_SESSION['UserId'], 0);
    if($today_expense == NULL) {
        $today_expense = "No Expenses Logged Today";
    } else {
        $today_expense = "₹ " . $today_expense;
    }

    // Yesterday's Expenses
    $Yesterday_expense = $getFromE->Yesterday_expenses($_SESSION['UserId']);
    if($Yesterday_expense == NULL) {
        $Yesterday_expense = "No Expenses Logged Yesterday";
    } else {
        $Yesterday_expense = "₹ " . $Yesterday_expense;
    }

    // Last 7 Days' Expenses 
    $week_expense = $getFromE->Expenses($_SESSION['UserId'], 6);
    if($week_expense == NULL) {
        $week_expense = "No Expenses Logged This Week";
    } else {
        $week_expense = "₹ " . $week_expense;
    }

    // Last 30 Days' Expenses
    $monthly_expense = $getFromE->Expenses($_SESSION['UserId'], 29);
    if($monthly_expense == NULL) {
        $monthly_expense = "No Expenses Logged In Last 30 Days";
    } else {
        $monthly_expense = "₹ " . $monthly_expense;
    }

    // Total Expenses
    $total_expenses = $getFromE->totalexp($_SESSION['UserId']);
    if($total_expenses == NULL) {
        $total_expenses = "No Expenses Logged Yet";
    } else {
        $total_expenses = "₹ " . $total_expenses;
    }

    // Budget Left for the month
    $budget_left = $getFromB->checkbudget($_SESSION['UserId']);
    if($budget_left == NULL) {
        $budget_left = "Not Data";
    } else 
    {
        $currmonexp = $getFromE->Current_month_expenses($_SESSION['UserId']);
        if($currmonexp == NULL) {
            $currmonexp = 0;
        }
        $budget_left = $budget_left - $currmonexp;
        $budget_left = "₹ " . $budget_left;
    }
    // Get the budget set for the month
    $monthly_budget = $getFromB->checkbudget($_SESSION['UserId']);
    if ($monthly_budget === NULL) {
    $monthly_budget = "Budget Not Set Yet";
    } else {
    $monthly_budget = "₹ " . $monthly_budget;
    }

    // Total Expenses for the Current Month
$current_month_expenses = $getFromE->Current_month_expenses($_SESSION['UserId']);
if ($current_month_expenses === NULL) {
    $current_month_expenses = "No Expenses This Month";
} else {
    $current_month_expenses = "₹ " . $current_month_expenses;
}


?>
</div>
  <div class="wrapper">
    <div class="row">
    <!-- Add a new card to display Today's Expenses -->
    <div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: 	Purple; border-radius: 8px;">
        <div class="counter bg-info" style="color: white; border-radius: 8px;">
            <p><i class="fa fa-check-square-o"></i></p>
            <h3>
                Today's Expenses
            </h3>
            <p style="font-size: 1.2em;">
            <?php echo str_replace('$', '₹', $today_expense) ?>
            </p>
        </div>
    </div>
</div>
    <!-- Add a new card to display Yesterday's Expenses -->
    <div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: 	DarkBlue; border-radius: 8px;">
        <div class="counter bg-info" style="color: white; border-radius: 8px;">
            <p><i class="fas fa-redo-alt"></i></p>
            <h3>
                Yesterday's Expenses
            </h3>
            <p style="font-size: 1.2em;">
            <?php echo str_replace('$', '₹', $Yesterday_expense) ?>
            </p>
        </div>
    </div>
</div>
        <!-- Add a new card to display Last 7 day's Expenses -->
        <div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: 	dodgerblue; border-radius: 8px;">
        <div class="counter bg-info" style="color: white; border-radius: 8px;">
            <p><i class="fas fa-check-double"></i>
            <h3>
            Last 7 day's Expenses
            </h3>
            <p style="font-size: 1.2em;">
            <?php echo str_replace('$', '₹', $week_expense) ?>
            </p>
        </div>
    </div>
</div>
        <!-- Add a new card to display Last 30 day's Expenses -->
        <div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: 	rosybrown; border-radius: 8px;">
        <div class="counter bg-info" style="color: white; border-radius: 8px;">
            <p><i class="fas fa-calendar-check"></i></p>
            <h3>
            Last 30 day's Expenses
            </h3>
            <p style="font-size: 1.2em;">
            <?php echo str_replace('$', '₹', $monthly_expense) ?>
            </p>
        </div>
    </div>
</div>
        <!-- Add a new card to display Current Month's Expenses -->
<div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: 	goldenrod; border-radius: 8px;">
        <div class="counter bg-info" style="color: white; border-radius: 8px;">
            <p><i class="far fa-calendar-alt"></i></p>
            <h3>
                Current Month's Expenses
            </h3>
            <p style="font-size: 1.2em;">
                <?php echo str_replace('$', '₹', $current_month_expenses) ?>
            </p>
        </div>
    </div>
</div>
<!-- Add a new card to display Total Expenses Till Now -->
<div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: 	orangered; border-radius: 8px;">
        <div class="counter bg-info" style="color: white; border-radius: 8px;">
            <p><i class="fas fa-file-invoice"></i></p>
            <h3>
                Total Expenses Till Now
            </h3>
            <p style="font-size: 1.2em;">
            <?php echo str_replace('$', '₹', $total_expenses) ?>
            </p>
        </div>
    </div>
</div>
       
 <!-- Add a new card to display Monthly Budget Set -->
 <div class="col-4 col-m-4 col-sm-4">
            <div class="card" style="background-color: 	teal; border-radius: 8px;">
                <div class="counter bg-info" style="color: white; border-radius: 8px;">
                    <p><i class="fas fa-coins"></i></p>
                    <h3>
                       Monthly Budget Set
                    </h3>
                    <p style="font-size: 1.2em;">
                        <?php echo str_replace('$', '₹', $monthly_budget) ?>
                    </p>
                </div>
            </div>
        </div>
<!-- Add a new card to display QUOTE -->
<div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: transparent; border-radius: 8px; border: 2px solid; padding: 10px; border-image: linear-gradient(to right, #FC466B, #3F5EFB) 1;">
        <div class="counter bg-info" style="color: linear-gradient(to right, #FC466B, #3F5EFB); border-radius: 8px;">
        <p><i class="far fa-grin-beam" style="background: -webkit-linear-gradient(#FC466B, #3F5EFB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i></p>
            <h3 style="background: -webkit-linear-gradient(#FC466B, #3F5EFB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                MANAGE FINANCE WISELY
            </h3>
            <p style="font-size: 1em; background: -webkit-linear-gradient(#FC466B, #3F5EFB); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                "Spend Consciously, Live Abundantly."
            </p>
        </div>
    </div>
</div>


 <!-- Add a new card to display Monthly Budget Left -->
 <div class="col-4 col-m-4 col-sm-4">
    <div class="card" style="background-color: 	darkslategrey; border-radius: 8px;">
        <div class="counter bg-info" style="color: white; border-radius: 8px;">
            <p><i class="fas fa-rupee-sign"></i></p>
            <h3>
                Monthly Budget Left
            </h3>
            <p style="font-size: 1.2em;">
            <?php echo str_replace('$', '₹', $budget_left) ?>
            </p>
        </div>
    </div>
</div>
       
    </div>
    </div>
    </div>
</div>