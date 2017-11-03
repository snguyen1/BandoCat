<?php
	class Document
	{
        //vars
        public $id;
        public $collection;
        public $libraryindex;
        public $title;
        public $needsreview; //bool

        public $startday;
        public $startmonth;
        public $startyear;
        public $endday;
        public $endmonth;
        public $endyear;


        public $fronturl;
        public $backurl;
        public $frontimage;
        public $backimage;
        public $frontthumbnail;
        public $backthumbnail;
        public $xmlfile;
        public $url = "../Images/Intermediate/Documents/";
        public $thumb_url = "../Images/Intermediate/Thumbnails/";
        public $completed;
	}

	class Maps extends Document
	{
        public $subtitle;
        public $scale;
        public $is;
        public $northarrow;
        public $street;
        public $poi;
        public $coordinates;
        public $coast;
        public $customername;
        public $fieldbooknumber;
        public $fieldbookpage;
        public $readability;
        public $rectifiability;
        public $companyname;
        public $documenttype;
        public $documentmedium;
        public $author;

		public function __construct($collection,$xmlpath,$username,$mapid)
		{
			$this->xmlfile = $xmlpath;
			$found = -1;
			$this->collection = $collection;
			$this->id = $mapid;

			$xml = simplexml_load_file($this->xmlfile) or die("Cannot open file!");
			foreach($xml->document as $a)
			{
				if($a->id == $this->id)
				{
                    $this->libraryindex = $a->libraryindex;
                    $this->title = $a->title;
                    $this->subtitle = $a->subtitle;
                    $this->scale = $a->scale;
                    $this->is= $a->is;
                    $this->needsreview = $a->needsreview;
                    $this->northarrow = $a->northarrow;
                    $this->street = $a->street;
                    $this->poi = $a->poi;
                    $this->coordinates = $a->coordinates;
                    $this->coast = $a->coast;
                    $this->customername = $a->customername;

                    $this->startday = $a->startday;
                    $this->startmonth = $a->startmonth;
                    $this->startyear = $a->startyear;
                    $this->endday = $a->endday;
                    $this->endmonth = $a->endmonth;
                    $this->endyear = $a->endyear;

                    $this->fieldbooknumber = $a->fieldbooknumber;
                    $this->fieldbookpage = $a->fieldbookpage;
                    $this->readability = $a->readability;
                    $this->rectifiability = $a->rectifiability;
                    $this->companyname = $a->companyname;
                    $this->documenttype = $a->documenttype;
                    $this->documentmedium = $a->documentmedium;
                    $this->author = $a->author;

                    $this->frontimage = $this->url. $a->frontimage;
                    $this->backimage = $this->url. $a->backimage;
                    $this->frontthumbnail = $this->thumb_url. $a->frontthumbnail;
                    $this->backthumbnail = $this->thumb_url. $a->backthumbnail;
                    $found = 1;
				}
				if($found == 1)
					break;
			}

		}

	}

	class Map extends Document
	{

	}

?>