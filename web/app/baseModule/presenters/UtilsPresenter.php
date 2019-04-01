<?php

namespace BaseModule\Presenters;

use BaseModule\Components\TemplateMailer;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Kdyby\Console\StringOutput;
use Kdyby\Doctrine\Console\SchemaUpdateCommand;
use Kdyby\Doctrine\EntityManager;
use Libs\ProjectInitializer;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;

class UtilsPresenter extends BasePresenter
{

    const HASH = 987654321;

    /** @var EntityManager @inject */
    public $em;
    /** @var SchemaUpdateCommand @inject */
    public $schema_update_command;
    /** @var ProjectInitializer @inject */
    public $project_initializer;

    public function startup()
    {
        parent::startup();
        if ($this->getParameter('hash') != self::HASH) {
            die('unallowed, provide password');
        }
    }

    public function beforeRender()
    {
        $this->addLinksToWeb();
        exit;
    }


    //////////////////////////// Actions

    public function actionDefault()
    {
        $this->showHelp();
    }

    public function actionInitProject()
    {
        $this->project_initializer->initialize();
    }

    public function actionShowLogs()
    {
        foreach (scandir('../log/') as $item) {
            if($item != '.' && $item != '..')
            echo '<a href="' . $this->link('showLog', ['filename' => $item, 'hash' => self::HASH]) . '" target="_blank">' . $item . '</a><br>';
        }
    }

    public function actionShowLog($filename)
    {
        echo file_get_contents('../log/' . $filename);

    }

    public function actionDeleteEmailSent()
    {
        $file = '../log/email-sent';
        if(file_exists($file)){
            unlink($file);
            echo 'deleted';
        } else{
            echo 'email-sent file not found';
        }
    }

    public function actionOrmSchemaToolUpdateAndInitProject()
    {
        $this->actionOrmSchemaToolUpdate();
        $this->project_initializer->initialize();
    }

    public function actionAddUser($username, $password)
    {
        if($this->is_dev_server){
            $this->project_initializer->addUser($username, $password);
        } else {
            echo 'this works only in dev server!';
        }
    }

    public function actionRenderEmailTemplate()
    {
        $this->template_mailer->renderTemplate();
    }

    public function actionOrmSchemaToolUpdate()
    {
        $input = new ArrayInput(array('--force' => true));
        $output = new StringOutput();

        \Nette\DI\Extensions\InjectExtension::callInjects($this->context, $this->schema_update_command);
        $this->schema_update_command->setHelperSet(new HelperSet(['em' => new EntityManagerHelper($this->em)]));
        $this->schema_update_command->run($input, $output);

        echo 'db schema updated<br />';
    }

    public function actionShow500()
    {
        $this->redirect(':Base:ErrorTest:e500');
    }

    public function actionShow404()
    {
        $this->redirect(':Base:ErrorTest:e404');
    }

    public function actionTruncateLogs()
    {
        $files = glob('../log/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }

        echo 'logs deleted';
    }

    public function actionFlushTemp()
    {
        $this->rrmdir('../temp/cache/');

        echo 'temp flushed';
    }

    public function actionDeleteTablesOrmUpdateInitProject()
    {
        if($this->is_dev_server){
            $connection = $this->em->getConnection();
            $schemaManager = $connection->getSchemaManager();
            $tables = $schemaManager->listTables();

            $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
            foreach($tables as $table) {
                $connection->executeUpdate('DROP TABLE ' . $table->getName());
            }
            $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');


            $this->actionOrmSchemaToolUpdateAndInitProject();

            echo '<br>tables deleted, orm updated, init proceeded';
        } else {
            echo 'this works only in dev server!';
        }
    }

    //////////////////////////// Other

    private function showHelp()
    {
        echo 'Actions available under utils: <br><br>';

        $this->showHelpLink('ormSchemaToolUpdateAndInitProject', 'used when initing new hosting - combination of <b>ormSchemaToolUpdate</b> and <b>initProject</b>');
        $this->showHelpLink('initProject', 'initializes basic data in project');
        $this->showHelpLink('showLogs', 'show log/');
        $this->showHelpLink('deleteEmailSent', 'deletes log file email-sent to enable email error notification to all@incolor.cz');
        $this->showHelpLink('renderEmailTemplate', 'renders email template for develop purposes');
        $this->showHelpLink('ormSchemaToolUpdate', 'updates DB schema, make sure you really wanna do that, it can cause DB problems!');
        $this->showHelpLink('show500', 'shows error 500 for testing purposes');
        $this->showHelpLink('show404', 'shows error 404 for testing purposes');
        $this->showHelpLink('truncateLogs', 'truncate log/');
        $this->showHelpLink('flushTemp', 'flush temp/cache');
        if($this->is_dev_server){
            $this->showHelpLink('/add-user?hash=' . self::HASH . '&username={username}&password={password}', 'adds admin user', true);
            $this->showHelpLink('deleteTablesOrmUpdateInitProject', 'delete tables and data from database, updates schema, inits the project');
        }
    }

    private function showHelpLink($action, $comment, $only_action_string = false)
    {
        if($only_action_string) {
            echo $action;
        } else {
            $link = $this->link($action, array('hash' => self::HASH));
            echo '<a href="' . $link . '">' . $link . '</a>';
        }
        echo ' - (' . $comment . ')<p />';
    }

    private function addLinksToWeb()
    {
        echo '<br><br>Links';
        echo ' | <a href="' . $this->link(':Base:Utils:', ['hash' => self::HASH]) . '">Utils</a>';
        echo ' | <a href="' . $this->link(':Front:Default:') . '">Web</a>';
        echo ' | <a href="' . $this->link(':Admin:Admin:') . '">Admin</a>';
    }













    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        $this->rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }

}