<?php
class Form_BugReportForm extends Zend_Form
{
    public function init()
    {
        $id = $this->createElement('hidden', 'id');
        $this->addElement($id);

        // add element: author textbox
        $author = $this->createElement('text', 'author');
        $author->setLabel('Enter your name:');
        $author->setRequired(true);
        $author->setAttrib('size', 30);
        $this->addElement($author);

        // add element: email textbox
        $email = $this->createElement('text', 'email');
        $email->setLabel('Your email address:');
        $email->setRequired(true);
        $email->addValidator(new Zend_Validate_EmailAddress());
        $email->addFilters(array(new Zend_Filter_StringTrim(), new
            Zend_Filter_StringToLower()));
        $email->setAttrib('size', 40);
        $this->addElement($email);

        // add element: date textbox
        $date = $this->createElement('text', 'date');
        $date->setLabel('Date the issue occurred (mm-dd-yyyy):');
        $date->setRequired(true);
        $date->addValidator(new Zend_Validate_Date('MM-DD-YYYY'));
        $date->setAttrib('size', 20);
        $this->addElement($date);

        // add element: URL textbox
        $url = $this->createElement('text', 'url');
        $url->setLabel('Issue URL:');
        $url->setRequired(true);
        $url->setAttrib('size', 50);
        $this->addElement($url);

        // add element: description text area
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Issue description:');
        $description->setRequired(true);
        $description->setAttrib('cols', 50);
        $description->setAttrib('rows', 4);
        $this->addElement($description);

        // add element: priority select box
        $priority = $this->createElement('select', 'priority');
        $priority->setLabel('Issue priority:');
        $priority->setRequired(true);
        $priority->addMultiOptions(array('low' => 'Low', 'med' => 'Medium', 'high' =>
            'High'));
        $this->addElement($priority);

        // add element: status select box
        $status = $this->createElement('select', 'status');
        $status->setLabel('Current status:');
        $status->setRequired(true);
        $status->addMultiOption('new', 'New');
        $status->addMultiOption('in_progress', 'In Progress');
        $status->addMultiOption('resolved', 'Resolved');
        $this->addElement($status);

        // add element: submit button
        $this->addElement('submit', 'submit', array('label' => 'Submit'));


    }
}
?>

