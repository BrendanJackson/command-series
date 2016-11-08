<?php namespace Acme;
//class version of test_app
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\ClientInterface;

class NewCommand extends Command {
	
	private $client;

	public function __construct(ClientInterface $client) 
		{
			$this->client = $client;

			parent::__construct();
		}	

	public function configure()
	{
		$this->setName("new")
			 ->setDescription("Create a new Laravel application")
			 //"name"==name of argument, arguement is optional or required, description of the arguement
			 ->addArgument("name", InputArgument::REQUIRED);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		//assert that the folder doesn't already exist
		$directory = getcwd() . "/" . $input->getArgument("name");

		$this->assert_application_does_not_exist($directory, $output);

		$this->download($this->make_file_name() )
			 ->extract();
		// download nightly version of Laravel

		// extract zip file

		// alert the user that they are ready to go

	}

	private function assert_application_does_not_exist ($directory, OutputInterface $output)
	{
		if (is_dir($directory))
		{
			$output->writeln("<error>Application already exists!</error>");
			exit(1);
		}
	}

	private function make_file_name() 
	{
		return getcwd() . "/laravel_" . md5(time().uniqid()) . ".zip";
	}

	private function download ($zipfile)
	{
		$response = $this->client->get("http://cabinet.laravel.com/latest.zip")->getBody();
		file_put_contents($zipfile, $response);
		return $this;
	}

}