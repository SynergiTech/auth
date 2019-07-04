<?php

namespace Auth;

class Migration
{
    /**
     * Check if an INDEX exists on a table.
     * This is a hack becaues DBUtil doesn't have this method and we
     * shouldn't need to rely on a particular version of fuel-core
     * @param  string $table_name      The table name to check on
     * @param  string $index_name The index name to check for
     * @return boolean			  Returns true if exists, false if doesn't
     */
    public static function check_index_exists($table_name, $index_name)
    {
        $dsn = \Config::get('db.'.\Config::get('db.active').'.connection.dsn');
        foreach (explode(';', $dsn) as $dsn_part) {
            $exploded = explode('=', $dsn_part);
            if ($exploded[0] == 'dbname') {
                $database_name = $exploded[1];
                break;
            }
        }

        if (!isset($database_name)) {
            throw new Exception('Database Name not able to fetched from DSN string');
        }

        try {
            $query = \DB::select('*')
                ->from('information_schema.statistics')
                ->where('table_schema', $database_name)
                ->where('table_name', $table_name)
                ->where('index_name', $index_name)
                ->execute();

            if ($query->count() > 0) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }
}
