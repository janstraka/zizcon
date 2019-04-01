<?php

namespace App\Forms;

use App\Model\Entity\Reservation;
use DateTime;
use Model\Reservations;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;


class TicketForm extends UI\Control
{
	public $onSave = [];

	private $reservations;

	/**
	 * AssignEventForm constructor.
	 * @param Reservations $reservations
	 * @internal param array $on_save
	 */
	public function __construct(Reservations $reservations)
	{
		parent::__construct();
		$this->reservations = $reservations;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . "/TicketForm.latte");
		$this->template->render();
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$ticket_type = array(

			'400' => '400,-',
			'500' => '500,-',
			'150' => '150,-',
			'200' => '200,-',
			'100' => '100,-',
			'360' => '360,-',
			'450' => '450,-',
			'135' => '135,-',
			'180' => '180,-',
			'90' => '90,-',
		);

		$form->addRadioList('ticket_price', 'Vyberte typ lístku:', $ticket_type)
			->setRequired('Vyberte prosím typ lístku')
			->setDefaultValue('500');
			//->setAttribute('class', 'form-control');

		$form->addText('quantity', 'Počet lístků:')
			->setRequired('Zadejte počet lístků')
			->addRule(Form::INTEGER, 'Počet lístků musí být číslo')->setValue('1')->setAttribute('class', 'form-control quantity');

		$form->addText('name', 'Jméno:')
			->setRequired('Zadejte prosím své jméno')->setAttribute('class', 'form-control')->setAttribute('class', 'form-control');

		$form->addText('surname', 'Příjmení:')
			->setRequired('Zadejte prosím své příjmení')->setAttribute('class', 'form-control');

		$form->addText('email', 'E-mail:')
			->setRequired('Zadejte prosím váš email')->setAttribute('class', 'form-control');

               $form->addText('phone', 'Telefon:')
			->setRequired('Zadejte prosím váš telefon')->setAttribute('class', 'form-control');

		$form->addSubmit('send', 'Odeslat')
			->setAttribute('class', 'btn btn-lg btn-primary btn-block');;
		$form->onSuccess[] = $this->processForm;
		return $form;
	}

	public function processForm(Form $form, $values)
	{
		$reservation = new Reservation();
		$reservation->setName($values->name);
		$reservation->setSurname($values->surname);
		$reservation->setName($values->name);
		$reservation->setPrice($values->ticket_price);
		$reservation->setQuantity($values->quantity);
		$reservation->setEmail($values->email);
		$reservation->setPhone($values->phone);
		$reservation->setDate(new DateTime());

		$this->reservations->save($reservation);

		$this->onSave($form, $values);

$mail = new Message;
$mail->setFrom('Jan Straka <bobbz@seznam.cz>')
    ->addTo('bobbz@seznam.cz')
    ->setSubject('Subject')
    ->setBody('Hello, Your order has been accepted.');

$mailer = new SendmailMailer;
$mailer->send($mail);



//$success = mail('bobbz@seznam.cz', 'My Subject', 'ahoj');
//if (!$success) {
//    $errorMessage = error_get_last()['message'];
//}

//$this->sendRegistrationEmail($values);

	}
        
        private function sendRegistrationEmail($values)
        {



               // Multiple recipients
               //$to = 'johny@example.com, sally@example.com'; // note the comma
               //$to = '{$values->email}'; // note the comma
               $to = 'bobbz@seznam.cz'; // note the comma

               // Subject
               $subject = 'Potvrzení registrace na ŽižCon Test';

               // Message
               $message = 'ahoj';

               $success = mail($to, $subject, $message);
               if ($success) {
                   $errorMessage = error_get_last()['message'];
               }
/*
               <html>
               <head>
                 <title>Birthday Reminders for August</title>
               </head>
               <body>
                 <p>Here are the birthdays upcoming in August!</p>
                 <table>
                   <tr>
                     <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
                   </tr>
                   <tr>
                     <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
                   </tr>
                   <tr>
                     <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
                   </tr>
                 </table>
               </body>
               </html>
               ';


               // To send HTML mail, the Content-type header must be set

               $headers[] = 'MIME-Version: 1.0';
               $headers[] = 'Content-type: text/html; charset=iso-8859-1';

               // Additional headers
               //$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
               //$headers[] = 'From: Birthday Reminder <birthday@example.com>';
                 //$headers[] = 'Cc: bobbz@seznam.cz';
               //$headers[] = 'Bcc: birthdaycheck@example.com';

               // Mail it
                 //mail($to, $subject, $message, implode("\r\n", $headers));
*/
      }


}

interface ITicketFormFactory
{
	/** @return TicketForm */
	function create();
}			