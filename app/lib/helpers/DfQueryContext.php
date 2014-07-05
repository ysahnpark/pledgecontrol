<?php namespace DocuFlow\Helper;

/**
 * Helper class that contextual information about query.
 */
class DfQueryContext {

	public $envelop = false; // Wheter or not to envelop with paging info
	public $page    = null;  // The current page
	public $offset  = null;  // Alternative to page: an offset
	public $limit   = 20;    // Maximum number of entries to return
	public $qparams;         // The query parameters
	public $boolop  = 'or';  // Wheter to conjunct (and) or disjunct (or) 

	public function __construct($loadFromInput = true) {
		if ($loadFromInput) {
			$this->fromInput();	
		}
    }

    /**
     * Returns the array representation of the context
     */
    public function toArray()
    {
    	return array(
    		'page' => $this->page,
    		'offset' => $this->offset,
    		'limit' => $this->limit,
    		'qparams' => $this->qparams,
    		'boolop' => $this->boolop
    		);
    }

	/**
	 * Generates links to download files
	 */
	public function fromInput()
	{
		$this->qparams = \Input::except(array('_envelop', '_offset', '_page', '_limit'));
		$this->envelop = \Input::get('_envelop', 0); // Whether or not to wrap in envelop including paging info
		$this->offset  = \Input::get('_offset', null);
		$this->page    = \Input::get('_page', null);
		$this->limit   = \Input::get('_limit', 20);
	}

	/**
	 * Returns the offset, either from the value or calculated form page
	 */
	public function getOffset()
	{
		if ($this->offset !== null) {
			//print("OFF:" . $this->offset);
			return $this->offset;
		}
		if ($this->page !== null) {
			//print("PAG:" . $this->page * $this->limit);
			return $this->page * $this->limit;
		}
		return 0;
	}

	/**
	 * Returns a criteria structure (MongoDB-like) based on the query parameter  
	 */
	public function buildCriteria()
	{
		$criteriaBuilder = new \DocuFlow\Helper\DfCriteriaBuilder();
        $criteria = $criteriaBuilder->buildFromQueryParams($this->qparams);
        return $criteria;
	}

	/**
	 * Return the value of a queryParam
	 */
	public function getQParamVal($name, $defVal = '')
	{
		return array_key_exists($name, $this->qparams) ? $this->qparams[$name] : $defVal;
	}
}