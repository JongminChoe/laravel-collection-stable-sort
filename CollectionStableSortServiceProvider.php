<?php

/**
 * Copyright 2020 Jongmin Choe
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionStableSortServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('stableSort', function ($callback = null) {
            $position = 0;
            $items = $this->map(function ($value) use (&$position) {
                $item = compact('position', 'value');
                $position++;
                return $item;
            })->all();
        
            $condition = static::wrap(
                $callback ?? [function ($a, $b) {
                    return $a['value'] <=> $b['value'];
                }]
            )->all(); 
        
            $callback = function ($a, $b) use ($condition) {
                foreach ($condition as $key => $order) {
                    if (is_int($key)) {
                        $key = $order;
                        $order = 1;
                    }
                    else if (strtolower($order) === 'desc') {
                        $order = -1;
                    }
                    else {
                        $order = 1;
                    }
        
                    $result = $key instanceof \Closure
                        ? $key($a['value'], $b['value'])
                        : $order * (data_get($a['value'], $key) <=> data_get($b['value'], $key));
        
                    if ($result !== 0) {
                        return $result;
                    }
                }
                return $a['position'] <=> $b['position'];
            };
        
            uasort($items, $callback);
        
            return (new static($items))->map->value;
        });
    }
}
