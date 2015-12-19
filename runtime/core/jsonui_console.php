<?php

class jsonui_console {

    private $foreground_colors = array();
    private $background_colors = array();

    private $term;
    
    const InputKeyUp = 1;
    const InputKeyDown = 2;
    const InputReturn = 3;
    const InputSpace = 4;
    
    public function __construct() {
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
        
        $this->term = `stty -g`;
        system("stty -icanon");
    }
    
    public function __destruct() {
        system("stty '".$this->term."'");
    }

    protected function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }
        $colored_string .= $string . "\033[0m";
        return $colored_string;
    }

    public function getForegroundColors() {
        return array_keys($this->foreground_colors);
    }

    public function getBackgroundColors() {
        return array_keys($this->background_colors);
    }

    public function writeln($string, $foreground_color = null, $background_color = null) {
        echo $this->getColoredString($string, $foreground_color, $background_color).PHP_EOL;
    }
    public function write($string, $foreground_color = null, $background_color = null) {
        echo $this->getColoredString($string, $foreground_color, $background_color);
    }
    
    public function ask($string, $default = NULL, $nullable = false) {
        $answer_buffer = $default;
        do {
            echo "\t".$this->getColoredString($string, "brown").(!is_null($default) ? " ".$this->getColoredString("(".$default.") "):"");
            while ($c = fread(STDIN, 1)) {
               // echo ord($c);
                if ($c == chr(10)) {
                    break;
                }  else if ($c == chr(8)) {
                    echo "\010\010\010   \010\010\010";
                } else {
                    $answer_buffer = $answer_buffer.$c;
                }
            }
            
            if (empty($answer_buffer)) {
                $answer_buffer = NULL;
                echo $this->getColoredString("\tEmpty string is not acceptable for this.", "red").PHP_EOL;
            }
        } while (!$nullable && empty($answer_buffer));
        return $answer_buffer;
    }
    
    protected function render_options($options, $selected_index) {
        $indexer = 0;
        foreach ($options as $option) {
            echo (($selected_index == $indexer)? "\t> ":"\t  ").$this->getColoredString($option["name"], "brown").PHP_EOL;
            $indexer++;
        }
    }
    public function options($string, $options, $selected_index = 0) {
        echo $this->writeln($string, "green");
        $indexer = 0;
        $options_count = count($options);
        $this->render_options($options, $selected_index);
        
        while ($c = fread(STDIN, 1)) {
            $indexer = 0;
            $update = false;
            
            if ($c == chr(66)) {
                if ($selected_index+1 < $options_count) {
                    $selected_index ++;
                    $update = true;                    
                } else {
                    $selected_index = 0;
                    $update = true;
                }
            } else if ($c == chr(65)) {
                if ($selected_index-1 >= 0) {
                    $selected_index --;
                    $update = true;                    
                } else {
                    $selected_index = $options_count - 1;
                    $update = true;
                }
            } else if ($c == chr(10)) {
                break;
            }
            
            echo chr(27) . "[0G". "     ";
            
            if ($update) {
                echo chr(27) . "[".$options_count."A";
                $this->render_options($options, $selected_index);
            }
        }
        
        if ($selected_index >= 0 && $selected_index < $options_count) {
            $option = $options[$selected_index];
            if (isset($option["callback"])) {
                $command = $option["callback"];
                if (!is_null($command)) {
                    $command($this);
                }
                return;                
            } else if (isset ($option["value"])) {
                return $option["value"];
            }
        }
    }
    
    protected function render_flags($selected_index, $options, $flags) {
        $indexer = 0;
        foreach ($options as $option) {
            $value = $option['value'];
            echo
                (($selected_index == $indexer)? "\t> ":"\t  ").
                ((($value & $flags) != 0)? "+ ":"  ").
                $this->getColoredString($option["name"], "brown").PHP_EOL;
            $indexer++;
        }
    }
    public function flags($string, $options, $flags) {
        echo $this->writeln($string, "green");
        $selected_index = 0;
        $options_count = count($options);
        $this->render_flags($selected_index, $options, $flags);
        
        while ($c = fread(STDIN, 1)) {
            $update = false;
            
            if ($c == chr(66)) {
                if ($selected_index+1 < $options_count) {
                    $selected_index ++;
                    $update = true;                    
                } else {
                    $selected_index = 0;
                    $update = true;
                }
            } else if ($c == chr(65)) {
                if ($selected_index-1 >= 0) {
                    $selected_index --;
                    $update = true;                    
                } else {
                    $selected_index = $options_count - 1;
                    $update = true;
                }
            } else if ($c == chr(10)) {
                break;
            } else if ($c == chr(32)) {
                $option = $options[$selected_index];
                $value = $option['value'];
                if (($value & $flags) != 0) {
                    $flags = $flags & ~$value;
                } else {
                    $flags = $flags | $value;
                }
                $update = true;
            } else if ($c == chr(84)) {
                echo "\010";
            }
            echo chr(27) . "[0G". "     ";
            
            if ($update) {
                echo chr(27) . "[".$options_count."A";
                $this->render_flags($selected_index, $options, $flags);                
            }
        }
        
        return $flags;
    }
    
    protected function movecursor($line, $column){
        echo "\033[{$line};{$column}H";
    }
    
    public function ask_roles() {        
    }
    public function ask_permissions() {
    }
    
    
    
}
