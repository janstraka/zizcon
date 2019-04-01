<?php
namespace Components;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Kdyby\Doctrine\Entities\BaseEntity;
use Libs\DivRenderer\BsFormRenderer;
use Nette\Application\UI\Form;


/**
 * Entity form
 *
 * @author Jan Marek
 */
class EntityForm extends Form
{
	private $entity;
	private $entityService;

	public function __construct()
	{
		parent::__construct();

		$this->addProtection('Bezpečnostní token formuláře vypršel, odešlete ho prosím znovu.');

		$this->setRenderer(new BsFormRenderer);
		// fiksme vyclenit do vlastni tridy

		// setup form rendering
		/*$renderer = $this->getRenderer();
		$renderer->wrappers['controls']['container'] = NULL;
		$renderer->wrappers['pair']['container'] = 'div';
		$renderer->wrappers['pair']['.error'] = 'has-error';
		$renderer->wrappers['control']['container'] = 'div';
		$renderer->wrappers['label']['container'] = 'div"';
		$renderer->wrappers['control']['description'] = 'span class=help-block';
		$renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';*/
		// make form and controls compatible with Twitter Bootstrap
		/*$this->getElementPrototype()->class('form-horizontal');
		foreach ($this->getControls() as $control) {
			exit;
			$control->getControlPrototype()->addClass('aaa');

			if ($control instanceof Controls\Button) {
				$control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
				$usedPrimary = TRUE;
			} elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
				$control->getControlPrototype()->addClass('form-control');
			} elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
				$control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
			}
		}*/
	}

	public function bindEntity($entity)
	{
		$this->entity = $entity;
		foreach ($this->getComponents() as $name => $input) {
			$name = str_replace('_', '', $name);

			if (method_exists($entity, "get$name")) {
				$method = "get$name";
			} elseif (method_exists($entity, "is$name")) {
				$method = "is$name";
			} else {
				continue;
			}
			$value = $entity->$method();
			if ($value === FALSE) {
				$value = 0;
			}

			if ($value instanceof BaseEntity) {
				$value = $value->getId();
			} elseif ($value instanceof ArrayCollection || $value instanceof PersistentCollection) {
				$value = array_map(function (BaseEntity $entity) {
					return $entity->getId();
				}, $value->toArray());
			}
			$input->setDefaultValue($value);
		}
	}

	public function getEntity()
	{
		return $this->entity;
	}

	public function getEntityService()
	{
		return $this->entityService;
	}

	public function setEntityService($entityService)
	{
		$this->entityService = $entityService;
	}

	public function handler($values)
	{
		unset($values->form_filler);

		return $this->getEntityService()->update($this->getEntity(), $values);
	}

	public function addFormFiller($string, $getTestingFields)
	{

	}


}