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
        $query = \DB::select('*')
            ->from('information_schema.statistics')
            ->where('table_schema', \DB::expr('DATABASE()'))
            ->where('table_name', $table_name)
            ->where('index_name', $index_name)
            ->execute();

        return $query->count() > 0;
    }
}
