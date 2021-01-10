<?php


$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$baseurl  = $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

if(isset($_GET['ajax']))
{
    $data = $_POST ?? [];
    $response = (object) [
        'success' => false,
        'data' => false
    ];


    $start = $data['start'] ?? false;
    $end   = $data['end'] ?? false;

    $min  = $data['min_value'] ? floatval( $data['min_value'] ) : 1;
    $max  = $data['max_value'] ? floatval( $data['max_value'] ): 100;

    if( $start && $end )
    {
        $start = (new DateTime())
        ->setTimestamp(strtotime($start))
        ->setTime(0,0);

        $end = (new DateTime())
        ->setTimestamp(strtotime($end))
        ->modify('+1 days')
        ->setTime(0,0);


        if( $start->getTimestamp() <= $end->getTimestamp()  )
        {
            # Header of CSV file
            $csv = [
                ['id', 'name', 'date', 'value']
            ];

            # Data of CSV file
            $id = 1;
            $mul = 100;
            for ($i = $start; $i < $end; $i->modify('+1 hours') ) 
            { 
                $date  = $i->format("Y-m-d H:i");
                $value = mt_rand($min * $mul, $max * $mul) / $mul;
                array_push($csv, [
                    $id, 'Test', $date, $value
                ]);
                $id++;
            }

            if( !empty($csv) )
            {
                $files_path = __DIR__."/files";
                $files_url  = $baseurl."/files";
                if(!is_dir($files_path))
                {
                    mkdir( $files_path, 0777 );
                }

                # Name of file
                $filename = "/example-data-".(new DateTime('NOW'))->getTimestamp().".csv";
        
                $fp = fopen($files_path.$filename, 'w');
                # Write fields
                foreach ($csv as $line) {
                    fputcsv($fp, $line);
                }
                fclose($fp);
                $response->success = true;
                $response->data = [
                    'link' => $files_url.$filename,
                ];
            }
        }

        
    }

    echo json_encode($response);
    exit();
}