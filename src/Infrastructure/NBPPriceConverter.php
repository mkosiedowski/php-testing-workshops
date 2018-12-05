<?php

namespace Infrastructure;

use Domain\Price;
use Domain\PriceConverter;
use Exception\CurrencyNotFoundException;

class NBPPriceConverter implements PriceConverter
{
    private const CSV_FILENAME = 'kursy.csv';
    private const DATA_DIR = '/../Resources/data/';

    /**
     * @inheritdoc
     */
    public function convert(Price $price, string $newCurrency): Price
    {
        // TODO: Implement proper convert() method using nbp.pl!

        $currencies = $this->openCsvFile();
        if (!array_key_exists($price->getCurrency(), $currencies) || !array_key_exists($newCurrency, $currencies)) {
            throw new CurrencyNotFoundException();
        }

        $currency = $currencies[$price->getCurrency()];
        $plnValue = round($price->getValue() * (float) $currency['rate'], 2);
        $currency = $currencies[$newCurrency];
        $newValue = round($plnValue / (float) $currency['rate'], 2);

        return new Price($newValue, $newCurrency);
    }

    /**
     * @return array
     */
    private function openCsvFile(): array
    {
        $data = [];
        if (($handle = fopen(__DIR__ . self::DATA_DIR . self::CSV_FILENAME, "r")) !== false) {
            fgetcsv($handle, 1000, ',');
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data[$row[1]] = [
                    'name' => $row[0],
                    'code' => $row[1],
                    'rate' => $row[2]
                ];
            }
            fclose($handle);
        }

        return $data;
    }
}
