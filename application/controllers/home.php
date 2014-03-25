<?php

class Home extends CI_Controller
{
	//---------------------------------------------------------------------------------------------------

	public function index()
	{
		$this->load->view('home/inc/header_view');
		$this->load->view('home/home_view');
		$this->load->view('home/inc/footer_view');
	}

	//---------------------------------------------------------------------------------------------------

	public function register()
	{
		$this->load->view('home/inc/header_view');
		$this->load->view('home/register_view');
		$this->load->view('home/inc/footer_view');
	}

	//---------------------------------------------------------------------------------------------------
	//Sony Mar24

	public function register_com()
	{
		$this->load->view('home/inc/header_view');
		$this->load->view('home/register_com_view');
		$this->load->view('home/inc/footer_view');
	}

}