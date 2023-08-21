<?php

namespace App\Services;

use App\Models\CompanySetting;

/**
 * SerialNumberFormatter
 * @package Crater\Services;
 */

class SerialNumberFormatter
{
    public const VALID_PLACEHOLDERS = [ 'SEQUENCE', 'DATE_FORMAT', 'SERIES', 'RANDOM_SEQUENCE', 'DELIMITER'];

    private $model;

    private $ob;


    private $company;

    /**
     * @var string
     */
    public $nextSequenceNumber;


    /**
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function setModelObject($id = null)
    {
        $this->ob = $this->model::find($id);

        if ($this->ob && $this->ob->sequence_number) {
            $this->nextSequenceNumber = $this->ob->sequence_number;
        }

        return $this;
    }

    /**
     * @param $company
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getNextNumber($data = null)
    {
        $modelName = strtolower(class_basename($this->model));
        $settingKey = $modelName.'_number_format';
        $companyId = $this->company;

        if (request()->has('format')) {
            $format = request()->format;
        } else {
            $format = CompanySetting::getSetting(
                $settingKey,
                $companyId
            );
        }
        $this->setNextNumbers();

        $serialNumber = $this->generateSerialNumber(
            $format
        );

        return $serialNumber;
    }

    public function setNextNumbers()
    {
        $this->nextSequenceNumber ?
            $this->nextSequenceNumber : $this->setNextSequenceNumber();

        return $this;
    }

    /**
     * @return $this
     */
    public function setNextSequenceNumber()
    {
        $companyId = $this->company;

        $last = $this->model::orderBy('sequence_number', 'desc')
            ->where('company_id', $companyId)
            ->where('sequence_number', '<>', null)
            ->take(1)
            ->first();

        $this->nextSequenceNumber = ($last) ? $last->sequence_number + 1 : 1;

        return $this;
    }

    public static function getPlaceholders(string $format)
    {
        $regex = "/{{([A-Z_]{1,})(?::)?([a-zA-Z0-9_]{1,6}|.{1})?}}/";

        preg_match_all($regex, $format, $placeholders);
        array_shift($placeholders);
        $validPlaceholders = collect();

        /** @var array */
        $mappedPlaceholders = array_map(
            null,
            current($placeholders),
            end($placeholders)
        );

        foreach ($mappedPlaceholders as $placeholder) {
            $name = current($placeholder);
            $value = end($placeholder);

            if (in_array($name, self::VALID_PLACEHOLDERS)) {
                $validPlaceholders->push([
                    "name" => $name,
                    "value" => $value
                ]);
            }
        }

        return $validPlaceholders;
    }

    /**
     * @return string
     */
    private function generateSerialNumber(string $format)
    {
        $serialNumber = '';

        $placeholders = self::getPlaceholders($format);

        foreach ($placeholders as $placeholder) {
            $name = $placeholder['name'];
            $value = $placeholder['value'];

            switch ($name) {
                    case "SEQUENCE":
                        $value = $value ? $value : 6;
                        $serialNumber .= str_pad($this->nextSequenceNumber, $value, 0, STR_PAD_LEFT);

                        break;
                    case "DATE_FORMAT":
                        $value = $value ? $value : 'Y';
                        $serialNumber .= date($value);

                        break;
                    case "RANDOM_SEQUENCE":
                        $value = $value ? $value : 6;
                        $serialNumber .= substr(bin2hex(random_bytes($value)), 0, $value);

                        break;
                    default:
                        $serialNumber .= $value;
                }
        }

        return $serialNumber;
    }
}
