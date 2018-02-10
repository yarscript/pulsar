<?php

namespace Admin\System;

use Ions\Mvc\Model;

class BackupModel extends Model
{
    public function restore($sql)
    {
        foreach (explode(";\n", $sql) as $row) {
            $row = trim($row);

            if ($row) {
                $this->db->execute($row);
            }
        }

        $this->cache->remove('*');
    }

    public function getTables()
    {
        $table_data = [];

        foreach (parent::getTables() as $result) {
                $table_data[] = array_shift($result);
        }

        return $table_data;
    }

    public function backup(array $tables)
    {
        $output = '';

        foreach ($tables as $table) {

            $output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

            $query = $this->db->query("SELECT * FROM `" . $table . "`");

            foreach ($query->rows as $result) {
                $fields = '';

                foreach (array_keys($result) as $value) {
                    $fields .= '`' . $value . '`, ';
                }

                $values = '';

                foreach (array_values($result) as $value) {
                    $value = str_replace(["\x00", "\x0a", "\x0d", "\x1a"], ['\0', '\n', '\r', '\Z'], $value);
                    $value = str_replace(["\n", "\r", "\t"], ['\n', '\r', '\t'], $value);
                    $value = str_replace('\\', '\\\\', $value);
                    $value = str_replace('\'', '\\\'', $value);
                    $value = str_replace('\\\n', '\n', $value);
                    $value = str_replace('\\\r', '\r', $value);
                    $value = str_replace('\\\t', '\t', $value);

                    $values .= '\'' . $value . '\', ';
                }

                $output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
            }

            $output .= "\n\n";
        }

        return $output;
    }
}
