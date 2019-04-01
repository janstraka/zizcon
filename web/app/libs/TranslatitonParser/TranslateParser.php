<?php

namespace Libs\TranslationParser;

use Model\BaseService;
use Model\Translations;
use Nette\Utils\ArrayHash;
use Nette\Utils\Arrays;
use PHPExcel;
use PHPExcel_IOFactory;

class TranslationParser
{
	/** @var PHPExcel @inject */
	public $PHP_Excel;

	private $sheet_languages = [];

	private $highest_column;

	private $highest_row;

	private $actual_sheet;

	private $last_translantion_key;

	private $array_hashes = [];

	private $translations;

	/**
	 * TranslationParser constructor.
	 */
	public function __construct($file, Translations $translations)
	{
		$this->PHP_Excel = PHPExcel_IOFactory::load($file);
		$this->translations = $translations;
	}

	/**
	 * @param $row Number of row in excel document
	 * @return array Array of cells in excel row
	 */
	private function getExcelRowToArray($row)
	{
		$array_row = [];
		for ($column = 0; $column < $this->highest_column; $column++) {
			$cell = $this->actual_sheet->getCellByColumnAndRow($column, $row);
			$array_row[$column] = $cell->getValue();
		}
		return $array_row;
	}

	/**
	 * @param $sheet_index index of sheet
	 * @throws \PHPExcel_Exception
	 */
	public function parseSheet($sheet_index) {

		echo 'Importing translantion from sheet: '.$this->PHP_Excel->getSheet($sheet_index)->getTitle().'<br>';
		$this->array_hashes = [];
		// skocim na zadany sheet (tab)
		$this->actual_sheet = $this->PHP_Excel->getSheet($sheet_index);
		//zmerim si ho (radky x sloupce)
		$this->highest_row = $this->actual_sheet->getHighestRow();
		// prevod znaku sloupce na cislo. A=1, B=2...
		$this->highest_column = ord($this->actual_sheet->getHighestColumn()) - 64;

		 if($this->actual_sheet->getCellByColumnAndRow(0,1) != 'translate_key'){
			 return;
		 }

		$excel_row = [];
		for ($row = 0; $row <= $this->highest_row; $row++) {
			if ($row == 1) {
				$this->initSheetLanguages($this->getExcelRowToArray($row));
				continue;
			}
			//nacteni celeho radku do pole
			$excel_row = $this->getLanguages($this->getExcelRowToArray($row));
			unset($excel_row);
		}

//		dump($this->array_hashes);
//		echo '<hr>';
//		dump($this->array_hashes['hotel_landmark']['hotel-anna']);


		foreach ($this->array_hashes as $arr) {
			foreach ($arr as $final => $value) {
				$this->translations->saveTranslations($value, $final); // fiksme entity key

				//dump($final);
			}
		}


	}

	private function initSheetLanguages($row)
	{
		for ($i = 2; $i < sizeof($row); $i++) {
			if ($row[$i] != null) {
				$this->sheet_languages[] = strtolower($row[$i]);
			}
		}
	}

	/**
	 * Parser for all sheets in translation document
	 */
	public function parseAllSheets()
	{
		$sheets_count = $this->PHP_Excel->getSheetCount();
		for ($i = 0; $i < $sheets_count; $i++) {
			$this->parseSheet($i);
		}
	}

	private function getLanguages($row)
	{
		// translantion_key != null

		if ($row[0] != null) {
			$translantion_key = $row[0];
			$entity_key = $row[1];
			$languages = [];
			$lan_index = 0;
			for ($i = 2; $i <= sizeof($row) - 1; $i++) {
				if ($row[$i]) {
					$languages[$this->sheet_languages[$lan_index]] = [$row[0] => $row[$i]];
				}
				$lan_index++;
			}
			if (sizeof($languages) > 0) {
				$languages = ArrayHash::from($languages);
			}

			if (isset($this->array_hashes[$translantion_key][$entity_key])) {

				foreach ($this->sheet_languages as $lang) {
					$this->array_hashes[$translantion_key][$entity_key]->$lang->$translantion_key .= ', ' . $languages->$lang->$translantion_key;
				}

			} else {
				$this->array_hashes[$translantion_key][$entity_key] = $languages;//= $languages;
			}

		}
	}
}

