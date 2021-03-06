<?php if (!defined('APPLICATION')) exit();
 
// Define the plugin:
$PluginInfo['MassMail'] = array(
   'Description' => 'Provides the opportunity to mass mail users according to role and other filters.',
   'Version' => '0.1',
   'RequiredApplications' => array('Vanilla' => '2.0.10'),
   'RequiredTheme' => FALSE, 
   'RequiredPlugins' => FALSE,
   'HasLocale' => FALSE,
   'SettingsUrl' => '/plugin/massmail',
   'SettingsPermission' => 'Garden.AdminUser.Only',
   'Author' => "Henry Hoggard",
   'AuthorEmail' => 'hoggardh@cardiff.ac.uk',
   'AuthorUrl' => 'http://www.henryhoggard.co.uk'
);
 
class MassMailPlugin extends Gdn_Plugin {
 

	public function PluginController_MassMail_Create($Sender) {
 
      $Sender->Title('Mass Mail');
      $Sender->AddSideMenu('plugin/MassMail');

      $Sender->Form = new Gdn_Form();

    
      $this->Dispatch($Sender, $Sender->RequestArgs);
   }

	 	
  public function Base_GetAppSettingsMenuItems_Handler($Sender) {
      $Menu = &$Sender->EventArguments['SideMenu'];
      $Menu->AddLink('Add-ons', 'Mass Mail', 'plugin/MassMail', 'Garden.AdminUser.Only');
   }


	   public function Controller_Index($Sender) {
	      // Prevent non-admins from accessing this page
	      $Sender->Permission('Vanilla.Settings.Manage');

	      $Sender->SetData('PluginDescription',$this->GetPluginKey('Description'));

	$Validation = new Gdn_Validation();
	      $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
	      $ConfigurationModel->SetField(array(
	         'Plugin.MassMail.Title' => 'test',
	         'Plugin.MassMail.Content' => 'test1',
	      ));

	      // Set the model on the form.
	      $Sender->Form->SetModel($ConfigurationModel);

	      // If seeing the form for the first time...
	      if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
	         // Apply the config settings to the form.
	         $Sender->Form->SetData($ConfigurationModel->Data);
	} else {
	         $ConfigurationModel->Validation->ApplyRule('Plugin.MassMail.Title', 'Required');

	         $ConfigurationModel->Validation->ApplyRule('Plugin.MassMail.Content', 'Required');

	         $Saved = $Sender->Form->Save();
	         if ($Saved) {
	            $Sender->StatusMessage = T("Your changes have been saved.");
	         }
	      }

	      // GetView() looks for files inside plugins/PluginFolderName/views/ and returns their full path. Useful!
	      $Sender->Render($this->GetView('mail.php'));
	   }

}

