<?php namespace Acme;
//class version of test_app
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\input\InputArgument;
use Symfony\Component\Console\input\InputInterface;
use Symfony\Component\Console\input\InputOption;
use Symfony\Component\Console\output\OutputInterface;

class SayHelloCommand extends Command {
	

	public function configure()
	{
		$this->setName("sayHelloTo")
			 ->setDescription("Offer a greeting to the given person.")
			 //"name"==name of argument, arguement is optional or required, description of the arguement
			 ->addArgument("name", InputArgument::REQUIRED, "Your Name Here!")
		 	 ->addOption("greeting", null, InputOption::VALUE_OPTIONAL, "Override the default greeting", "Hello");
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		// $message = "Hello, " . $input->getArgument("name");

		$message = sprintf("%s, %s", $input->getOption("greeting"), $input->getArgument("name"));

		$output->writeln("<comment>{$message}</comment>");
	}

}