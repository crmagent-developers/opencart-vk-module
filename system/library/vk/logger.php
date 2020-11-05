<?php
class Logger
{
    private $logPath;
    private $files;
    
    public function __construct($logPath = DIR_LOGS, $files = 10)
    {
        $this->logPath = $logPath;
        $this->files = $files;
    }
    
    public function write($dump, $file = 'info', $typeData = 'array')
    {
        $file = $this->logPath . '/' . $file . '.log';  

        if ($typeData == 'array') {
            $data['TIME'] = date('Y-m-d H:i:s');
            $data['DATA'] = $dump;
        } elseif($typeData == 'string') {
            if (is_array($dump)) {

                foreach ($dump as $key => &$item) {
                    $item = $key . ': ' . $item;
                }

                unset($item);

                $dump = implode('; ', $dump);
            }

            $data = '[' . date('Y-m-d H:i:s') . '] - ' . $dump . PHP_EOL;
        }

        $f = fopen($file, "a+");
        fwrite($f, print_r($data, true));
        fclose($f); 

        // if filesize more than 5 Mb rotate it
        if (filesize($file) > 5242880) {
            $this->rotate($file);
        } 
    }

    private function rotate($file)
    {
        $path = pathinfo($file);
        $rotate = implode('', array(
            $path['dirname'],
            '/',
            $path['filename'],
            '_',
            date('Y-m-d_H:i:s'),
            '.',
            $path['extension']
        ));

        copy($file, $rotate);
        $this->clean($file);

        $files = glob($path['dirname'] . '/' . $path['filename'] . "*" . ".log");

        if (0 === $this->files) {
            return;
        }

        if (count($files) > $this->files) {
            natsort($files);
            $files = array_reverse($files);
            foreach (array_slice($files, $this->files) as $log) {
                if (is_writable($log)) {
                    unlink($log);
                }
            }
        }
    }

    private function clean($file)
    {
        file_put_contents($file, '');
    }
}
