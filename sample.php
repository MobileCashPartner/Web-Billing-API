<?php
include 'src/MobileCashPartner/WebBillingApi.php';
include 'src/MobileCashPartner/BillingAmount.php';
include 'src/MobileCashPartner/BillingCategories.php';


$apiKey = ''; // MCASHP API Key
$webBillingApi = new \MobileCashPartner\WebBillingApi($apiKey);

/**
 * Start Billing
 */

switch($_GET['action']){
	default:
		?>
			<form method="get">
				<input type="hidden" name="action" value="start" />
				<input type="text" name="msisdn" placeholder="MSISDN (0049xxx)" />
				<br />
				<input type="submit" />
			</form>
		<?php
	break;
	case 'start':
		$start = $webBillingApi
			->setCategory(\MobileCashPartner\BillingCategories::WEBACCESS) // Category
			->setGrossAmount(\MobileCashPartner\BillingAmount::E049) // Item / Gross Amount (€)
			->setDescription('TESTTEST') // Description
			->setProductUrl('TEST') // Product URL
			->setDestination($_GET['msisdn']) // MSISDN
			->startWebBilling();


		switch($start->Status){
			case 'Success':
				?>
				TAN sent, check TAN! <br />
				<form method="get">
					<input type="hidden" name="action" value="check" />
					<input type="hidden" name="RequestID" value="<?php echo $start->RequestID; ?>" />
					<input type="hidden" name="TransactionID" value="<?php echo $start->TransactionID; ?>" />
					<input type="text" name="tan" placeholder="TAN" />
					<br />
					<input type="submit" />
				</form>
				<?php
			break;
			case 'Error':
				echo 'Following Error occured: ';
				echo $start->ErrorText;
			break;
		}
	break;
	case 'check':
		$tan = $webBillingApi
			->setRequestId($_GET['RequestID'])
			->setTransactionId($_GET['TransactionID'])
			->setTan($_GET['tan'])
			->checkTan();
		switch($tan->Status){
			case 'Success':
				?>
				TAN OK! <br />
				<form method="get">
					<input type="hidden" name="action" value="booking" />
					<input type="hidden" name="RequestID" value="<?php echo $start->RequestID; ?>" />
					<input type="submit" />
				</form>
				<?php
			break;
			case 'Error':
				echo 'Following Error occured: ';
				echo $tan->ErrorText;
			break;
		}
	break;
	case 'booking':
		$booking = $webBillingApi
			->setRequestId($_GET['RequestID'])
			->setTransactionId($_GET['TransactionID'])
			->booking();
		switch($booking->Status){
			case 'Success':
				echo 'TAN sent, now check tan';
			break;
			case 'Error':
				echo 'Following Error occured: ';
				echo $booking->ErrorText;
			break;
		}
	break;
}
