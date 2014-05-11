<?php
namespace MobileCashPartner;

class WebBillingApi{
	private $apiKey;
	private $apiUrl = 'http://billing.mcashp.com/api/webbilling/';

	private $destination;
	private $category;
	private $description;
	private $productUrl;
	private $grossAmount;

	private $tan;

	private $requestId;
	private $transactionId;
	/**
	 * Class Constructor
	 * @param string $apiKey MCASHP API Key
	 */
	public function __construct($apiKey){
		$this->apiKey = $apiKey;
	}

	/**
	 * starts web billing
	 * @return stdClass result
	 */
	public function startWebBilling(){
		$data['destination'] = $this->getDestination();
		$data['category'] = $this->getCategory();
		$data['description'] = $this->getDescription();
		$data['product_url'] = $this->getProductUrl();
		$data['gross_amount'] = $this->getGrossAmount();

		return $this->makeRequest('start', $data);
	}

	public function checkTan(){
		$data['tan'] = $this->getTan();
		$data['RequestID'] = $this->getRequestId();
		$data['TransactionID'] = $this->getTransactionId();

		return $this->makeRequest('checktan', $data);
	}

	public function booking(){
		$data['RequestID'] = $this->getRequestId();
		$data['TransactionID'] = $this->getTransactionId();

		return $this->makeRequest('booking', $data);
	}

	/**
	 * makes a request to the api
	 * @param string $url Method used for the API
	 * @param array $data GET data for the API call
	 * @return stdClass result
	 */
	private function makeRequest($url, $data){
		$data['api_key'] = $this->getApiKey();

		foreach ($data as $key => $value) {
		    $value = trim($value);
		    if (empty($value)){
		        throw new \Exception('Missing Parameters');
		    }
		}

		$param = http_build_query($data);

		$ch = curl_init();  
 
	    curl_setopt($ch,CURLOPT_URL, $this->getApiUrl().$url.'?'.$param);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	    $output=curl_exec($ch);
	 
	    curl_close($ch);
	    $result = json_decode($output);

	    return $result;
	}



    /**
     * Gets the value of destination.
     *
     * @return string Destination
     */
    public function getDestination()
    {
        return $this->destination;
    }
    
    /**
     * Sets the value of destination.
     *
     * @param string $destination MSISDN in Destination Format
     *
     * @return self
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Gets the value of category.
     *
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Sets the value of category.
     *
     * @param mixed $category the category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Gets the value of description.
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the value of description.
     *
     * @param mixed $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }




    /**
     * Gets the value of productUrl.
     *
     * @return mixed
     */
    public function getProductUrl()
    {
        return $this->productUrl;
    }
    
    /**
     * Sets the value of productUrl.
     *
     * @param mixed $productUrl the product url
     *
     * @return self
     */
    public function setProductUrl($productUrl)
    {
        $this->productUrl = $productUrl;

        return $this;
    }

    /**
     * Gets the value of grossAmount.
     *
     * @return mixed
     */
    public function getGrossAmount()
    {
        return $this->grossAmount;
    }
    
    /**
     * Sets the value of grossAmount.
     *
     * @param mixed $grossAmount the gross amount
     *
     * @return self
     */
    public function setGrossAmount($grossAmount)
    {
        $this->grossAmount = $grossAmount;

        return $this;
    }
    
    /**
     * Gets the value of apiKey.
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    /**
     * Gets the value of apiUrl.
     *
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Gets the value of tan.
     *
     * @return mixed
     */
    public function getTan()
    {
        return $this->tan;
    }
    
    /**
     * Sets the value of tan.
     *
     * @param mixed $tan the tan
     *
     * @return self
     */
    public function setTan($tan)
    {
        $this->tan = $tan;

        return $this;
    }

    /**
     * Gets the value of requestId.
     *
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }
    
    /**
     * Sets the value of requestId.
     *
     * @param mixed $requestId the request id
     *
     * @return self
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;

        return $this;
    }

    /**
     * Gets the value of transactionId.
     *
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }
    
    /**
     * Sets the value of transactionId.
     *
     * @param mixed $transactionId the transaction id
     *
     * @return self
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }
}