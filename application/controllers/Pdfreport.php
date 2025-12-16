<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdfreport extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array(
			'efeedor_model',
			'ticketsadf_model', //1
			'tickets_model', //2
			'ticketsint_model', //3
			'ticketsop_model', // 4
			'ticketsesr_model', // 5 
			'ticketspdf_model', // 5 
			'ticketsgrievance_model',  //  6
			'ticketsincidents_model', // 7 
			'ipd_model',
			'opf_model',
			'pc_model',
			'post_model',
			'doctorsfeedback_model',
			'ticketsdoctor_model',
			'doctorsopdfeedback_model',
			'ticketsopddoctor_model',
			'isr_model',
			'incident_model',
			'grievance_model',
			'admissionfeedback_model',
			'departmenthead_model',
			'setting_model'
		));
		$this->load->library('Pdf');
	}


	public function index()
	{
		// 
		// $this->load->view('pdfreport');

	}

	public function process_image_post(){
		$this->session->set_userdata('imageData',$_POST['imageData']);
		print_r($_SESSION);
		echo 'success';
		exit;
	}
	public function adf_pdf_report()
	{
		
		$this->load->view('downloads/adf_pdf_report');
	}

	public function ip_pdf_report()
	{
		
		$this->load->view('downloads/ip_pdf_report');
	}
	public function pdf_pdf_report()
	{
		
		$this->load->view('downloads/pdf_pdf_report');
	}

	public function op_pdf_report()
	{
		
		$this->load->view('downloads/op_pdf_report');
	}

	public function doctor_pdf_report()
	{
		
		$this->load->view('downloads/doctor_pdf_report');
	}

	public function doctoropd_pdf_report()
	{
		
		$this->load->view('downloads/doctoropd_pdf_report');
	}

	public function pc_pdf_report()
	{
		
		$this->load->view('downloads/pc_pdf_report');
	}
	public function esr_pdf_report()
	{
		
		$this->load->view('downloads/esr_pdf_report');
	}

	public function incident_pdf_report()
	{
		
		$this->load->view('downloads/incident_pdf_report');
	}



	public function grievance_pdf_report()
	{
		$this->load->view('downloads/grievance_pdf_report');
	}


	public function ebook()
	{
		$this->load->view('downloads/ebook');
	}


	public function ebook2()
	{
		$this->load->view('downloads/ebook2');
	}
	public function ebook3()
	{
		
		$this->load->view('ebook');
	}

	public function comment_ip()
	{
		
		$this->load->view('comment_ip');
	}

	public function comment_op()
	{
		
		$this->load->view('comment_op');
	}
}
