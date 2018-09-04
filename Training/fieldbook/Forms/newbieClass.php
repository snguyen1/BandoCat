<?php
	class Document
	{
		//vars
		public $id;
		public $bookcollection;
		public $libraryindex;
        public $needsreview; //bool


		public $startday;
		public $startmonth;
		public $startyear;
		public $endday;
		public $endmonth;
		public $endyear;


		public $fronturl;
		public $frontimage;
		public $frontthumbnail;
		public $xmlfile;
		public $url = "../Images/Newbie/Documents/";
		public $thumb_url = "../Images/Newbie/Thumbnails/";
		public $completed;
	}

	class Fiedlbook extends Document
	{
        public $booktitle;
        public $jobnumber;
        public $jobtitle;
        public $indexedpage;
        public $blankpage;
        public $sketch;
        public $loosedocument;
        public $crewmember;
		public $author;
		public $comments;

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
				    $this->bookcollection = $a->bookcollection;
					$this->booktitle = $a->booktitle;
					$this->jobnumber = $a->jobnumber;
					$this->jobtitle = $a->jobtitle;
					$this->indexedpage = $a->indexedpage;
					$this->blankpage = $a->blankpage;
					$this->sketch = $a->sketch;
					$this->loosedocument = $a->loosedocument;
					$this->needsreview = $a->needsreview;
					$this->author = $a->author;
					$this->crewmember = $a->crewmember;

					$this->startday = $a->startday;
					$this->startmonth = $a->startmonth;
					$this->startyear = $a->startyear;
					$this->endday = $a->endday;
					$this->endmonth = $a->endmonth;
					$this->endyear = $a->endyear;

					$this->comments = $a->comments;

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
?>