<?php
include 'controller.php';

class BogusController extends Controller
{
	public function Index()
	{
		$data = [
			'thing1' => 1,
			'thing2' => 2,
			'thing3' => 3
		];
		$this->SetViewData($data);

		return View();
	}
}
?>
