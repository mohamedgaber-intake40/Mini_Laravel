<?php
/**
 * Created by PhpStorm.
 * User: Mohamed.Gaber
 * Date: 01/10/2020
 * Time: 02:27 م
 */

namespace Core\Excel;
//require_once ROOT . '/vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class ExcelExporter
{
    private $right_to_left;
    private $active_sheet_index;
    private $columns;
    private $columns_width;
    private $columns_head;
    private $style_array;
    private $data;
    private $file_name;


    private function __construct(array $data)
    {
        $this->data = $data;
        $this->right_to_left = false;
        $this->style_array = array('font' => array('bold' => true));
        $this->active_sheet_index = 0;
        $this->file_name = 'data';
    }

    public static function create(array $data)
    {
        return new self($data);
    }

    public function setColumnWidth(array $columns_width)
    {
        $this->columns_width = $columns_width;
        return $this;
    }

    public function setActiveSheetIndex($index)
    {
        $this->active_sheet_index = $index;
        return $this;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function setColumnsHead(array $columns_head)
    {
        $this->columns_head = $columns_head;
        return $this;

    }

    public function export(array $mapping)
    {
        $spread_sheet = new Spreadsheet();
        $spread_sheet->getActiveSheet()->setRightToLeft($this->right_to_left);
        $spread_sheet->setActiveSheetIndex($this->active_sheet_index);
        $spread_sheet = $this->buildColumns($spread_sheet);
        $spread_sheet = $this->generateCells($mapping,$spread_sheet);
        $this->send($spread_sheet);

    }

    private function buildColumns(Spreadsheet $spread_sheet)
    {
        //set columns width
        foreach ($this->columns_width as $idx => $width) {
            $spread_sheet->getActiveSheet()->getColumnDimension($this->columns[$idx])->setWidth($width);
        }

        //set columns head
        foreach ($this->columns_head as $idx => $head) {
            $column = $this->columns[$idx] . '1';
            $spread_sheet->getActiveSheet()->setCellValue($column,$head);
        }

        //set columns head style
        foreach ($this->columns as $idx => $column) {
            $column = $this->columns[$idx] . '1';
            $spread_sheet->getActiveSheet()->getStyle($column)->applyFromArray($this->style_array);
        }
        return $spread_sheet;
    }

    private function generateCells(array $mapping , Spreadsheet $spreadsheet)
    {
        $row_count = 2;

        foreach ($this->data as $item)
        {
            foreach ($mapping as $column=> $value)
            {
                $spreadsheet->getActiveSheet()->setCellValueExplicit($column.$row_count , $item->$value,DataType::TYPE_STRING);
            }
            $row_count ++ ;
        }

        return $spreadsheet;
    }

    private function send($spread_sheet)
    {
        try {
            $writer = IOFactory::createWriter($spread_sheet, 'Xls');
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$this->file_name.xls");
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } catch (Exception $e) {
            echo $e;
            exit;
        }

    }

    public function setFileName($name)
    {
        $this->file_name = $name;
        return $this;
    }


}
