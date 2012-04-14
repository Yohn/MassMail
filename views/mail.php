<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?php echo T($this->Data['Title']); ?></h1>
<div class="Info">
   <?php echo T($this->Data['PluginDescription']); ?>
</div>
<h3><?php echo T('Settings'); ?></h3>
<?php
   echo $this->Form->Open();
   echo $this->Form->Errors();
?>
<ul>
   <li><?php
      echo $this->Form->Label('Title', 'Plugin.MassMail.Title');
	  echo $this->Form->TextBox('Plugin.Example.Title');
      
   ?></li>
   <li><?php
      echo $this->Form->Label('Content', 'Plugin.Example.Content');
      echo $this->Form->Textbox('Plugin.Example.Content');
   ?></li>
</ul>
<?php
   echo $this->Form->Close('Save');
?>