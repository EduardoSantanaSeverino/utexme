<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Crypt;
use DateTime;
use Response;
use Storage;
use Illuminate\Http\Request;

class DisplayController extends Controller
{

	private $serverPath = "/home2/utexme/public_html/utex";

	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request)
	{
		
		$screenDirectories = scandir($this->serverPath . "/files/screens");
		
		$usersList = collect();
		$dateList = collect();
		$hasUser = $request -> has ('u');

		if ($hasUser) {

			$userName = $request -> input ('u');

			foreach($screenDirectories as $dirName) {

				if ($dirName != "." && $dirName != "..") {

					$usersList -> push([
						'id' => $dirName, 
						'name' => $dirName, 
						'selected' => ($dirName == $userName)
					]);

				}
				
			}

			$dateFolders = scandir($this->serverPath . "/files/screens/" . $userName);

			foreach($dateFolders as $d) {

				if ($d != "." && $d != "..") {

					$dateList -> push([
						'id' => $d, 
						'name' => $d
					]);

				}
				
			}

		}
		else {
			
			foreach($screenDirectories as $dirName) {

				if ($dirName != "." && $dirName != "..") {

					$usersList -> push([
						'id' => $dirName, 
						'name' => $dirName, 
						'selected' => false
					]);

				}
				
			}

		}

		return View('display.index', compact('usersList', 'dateList'));
	}

	public function getData($action)
	{

		$date                            = Request("date");
		$userId                          = Request("userId");
		$jtSorting                       = Request('jtSorting');
		$jtStartIndex                    = Request('jtStartIndex');
		$jtPageSize                      = Request('jtPageSize');

		if(false){
			// testing variables : - >
			$testArray                   			= array(
				"date"                        		=> $date,
				"userId"                         	=> $userId,
				"jtSorting" 	                    => $jtSorting,
				"jtStartIndex" 	               		=> $jtStartIndex,
				"jtPageSize"         	          	=> $jtPageSize
			);
			dd($testArray);
		}

		switch ($action)
		{
			case 'list':
				
				$query = collect();

				$iCount = 0;
				foreach (glob($this -> serverPath . "/files/screens/" . $userId . "/" . $date . "/*.jpg") as $filename) {
					$iCount++;
					$query -> push([
						'id' => $iCount, 
						'name' => basename($filename,".jpg"), 
						'imageUrl' => str_replace($this->serverPath, "", $filename)
					]);
				}

				$query 						= $query -> sortByDesc('id');
				
				$rows                      	= $query -> count();
				
				$query = $query -> slice($jtStartIndex, $jtPageSize);
				
				return Response::json(
					array(
						"Result"			          	=>		"OK",
						"TotalRecordCount"	      		=>		$rows,
						"Records"			          	=>		$query -> values() -> all() ,
					)
				);

				break;


		}

	}

}
