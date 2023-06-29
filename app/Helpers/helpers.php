<?php

use App\DTO\OperatingModeModelDTO;
use App\DTO\SocialNetworksDTO;

if (!function_exists('getNameFromNumber')) {
    /**
     * Генерируем название сплит-теста
     *
     * @param $num
     *
     * @return string
     */
    function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);

        if ($num2 > 0) {
            return getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
}

if (!function_exists('cp_clear_phone')) {
    function clearPhone(?string $phone = null) {
        if (empty($phone)) return null;

        $phone = preg_replace('/[^0-9+]/', '', $phone);
        $isSevenFirst = $phone[0] == '7';
        $number = '';

        if ($isSevenFirst) {
            $number = '+';
        }

        $number .= $phone;

        return $number;
    }
}

if (!function_exists('parseFieldsFromStr')) {
    /**
     * @param $str
     * @param Closure $formatting
     *
     * @return array
     */
    function parseFieldsFromStr($str, \Closure $formatting) {
        $fields = [];

        if ( ! $str ) {
            return $fields;
        }

        $lines  = explode("\n", $str);

        foreach ( $lines as $line ) {
            $l = preg_replace('/[\r\n]+/', '', $line);
            preg_match("/^(?P<key>[\w\s\/№]+):\s+?(?P<value>.*)/u", $l, $matches);

            if ( isset($matches['key']) && isset($matches['value']) ) {
                $fields = array_merge($fields, [$formatting($matches['key'], $matches['value'])]);
            }
        }

        return $fields;
    }
}

if (!function_exists('prepareTableData')) {
    function prepareTableData($list, \Closure $callback) {
        $data = [];

        if ( is_array($list) ) {
            usort($list, function ($item1, $item2) {
                return $item1['sort'] <=> $item2['sort'];
            });

            foreach ( $list as $values ) {
                if ( isset($values['_remove_']) && $values['_remove_'] ) {
                    continue;
                }

                $item = $callback($values);

                if ( $item ) {
                    $data[] = $item;
                }
            }
        }

        return $data;
    }
}

if (!function_exists('getSocialNetworks')) {
    function getSocialNetworks($list) {
        return prepareTableData($list, function ($values) {
            if ( $values['name'] && $values['url'] ) {
                return new SocialNetworksDTO($values);
            }

            return null;
        });
    }
}

if (!function_exists('getOperationMode')) {
    function getOperationMode($list) {
        return prepareTableData($list, function ($values) {
            if ( $values['name'] && $values['value'] ) {
                return new OperatingModeModelDTO($values);
            }

            return null;
        });
    }
}

if (!function_exists('prepareOrderFormFields')) {
    function prepareOrderFormFields(array $fields, ?array $labels = null) {
        if (is_null($labels)) {
            $labels = [];
        }

        return array_map(function ($value, $key) use ($labels) {
            return ['key' => $key, 'name' => $labels[$key] ?? $key, 'value' => $value];
        }, array_values($fields), array_keys($fields));
    }
}

if (!function_exists('getImageNameWithoutExt')) {
    function getImageNameWithoutExt(string $name) {
        $blocks = explode('.', $name);
        array_pop($blocks);
        return implode('', $blocks);
    }
}

if (!function_exists('generateImageName')) {
    function generateImageName(\Illuminate\Http\UploadedFile $file) {
        $index     = 1;
        $extension = $file->getClientOriginalExtension();
        $original  = \Illuminate\Support\Str::slug(getImageNameWithoutExt($file->getClientOriginalName()));
        $new       = sprintf('%s_%s.%s', $original, $index, $extension);

        while (\Illuminate\Support\Facades\Storage::exists("images/$new")) {
            $index++;
            $new = sprintf('%s_%s.%s', $original, $index, $extension);
        }

        return $new;
    }
}