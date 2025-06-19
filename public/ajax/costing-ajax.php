<?php
    function isWeekend($date) {
        $weekday = date('N', strtotime($date)); // 5 for Friday, 6 for Saturday
        return ($weekday == 5 || $weekday == 6);
    }
    
    function generateRoomDescription($rooms) {
        $descriptions = [];
    
        foreach ($rooms as $type => $count) {
            if ($count > 0) {
                $descriptions[] = ucfirst($type) . "($count)";
            }
        }
    
        return implode(', ', $descriptions);
    }
    
    function formatFoodDescriptions($food) {
        $descriptions = [];
    
        foreach ($food as $city => $items) {
            $formattedItems = array_map(function($item) {
                return ucfirst(str_replace(['-makka', '-madina'], '', $item));
            }, $items);
    
            $descriptions[$city] = implode(', ', $formattedItems);
        }
    
        return $descriptions;
    }

    function calculateCost($stay, $rooms, $food, $pricingData) {
        $totalCosts = [
            'makka' => ['room' => 0, 'food' => 0],
            'madina' => ['room' => 0, 'food' => 0]
        ];

        $formattedDescriptions = formatFoodDescriptions($food);
        
    
        foreach ($stay as $city => $dates) {
            $startDate = new DateTime($dates['from']);
            $endDate = new DateTime($dates['to']);
            $interval = new DateInterval('P1D');
            $dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));
            
    
            foreach ($dateRange as $date) {
                $dateStr = $date->format('Y-m-d');
                $isWeekend = isWeekend($dateStr);
    
                foreach ($pricingData[$city] as $periods) {
                    foreach ($periods as $pricing) {
                        if ($dateStr >= $pricing['from_date'] && $dateStr <= $pricing['to_date']) {
                            // Calculate room cost
                            foreach ($rooms[$city] as $roomType => $count) {
                                if ($count > 0) {
                                    $roomKey = $roomType . '-room';
                                    if (isset($pricing[$roomKey])) {
                                        $totalCosts[$city]['room'] += $count * $pricing[$roomKey][$isWeekend ? 'weekend' : 'weekday'];
                                    }
                                }
                            }
    
                            // Calculate food cost
                            foreach ($food[$city] as $foodType) {
                                $foodKey = preg_replace('/-(makka|madina)$/', '', $foodType);
                                if (isset($pricing[$foodKey])) {
                                    $totalCosts[$city]['food'] += $pricing[$foodKey][$isWeekend ? 'weekend' : 'weekday'];
                                } else {
                                    echo "Food key $foodKey not found in pricing data\n"; // Debugging line
                                }
                            }

                        }
                    }
                }
            }
        }
    
        return [
            [
                [
                    "Name: " => "Hotel Room: ",
                    [
                        'makka' => [
                            "description" => generateRoomDescription($rooms['makka']), 
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => $totalCosts['makka']['room']
                            ]
                        ],
                        'madina' => [
                            "description" => generateRoomDescription($rooms['madina']),
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => $totalCosts['madina']['room']
                            ]
                        ],
                    ],
                ],
                [
                    "Name: " => "Hotel Food: ",
                    [
                        'makka' => [
                            "description" => $formattedDescriptions['makka'],
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => $totalCosts['makka']['food']
                            ]
                        ],
                        'madina' => [
                            "description" => $formattedDescriptions['madina'],
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => $totalCosts['madina']['food']
                            ]
                        ],
                    ],
                ],
            ]
        ];
    }


    function calculate_cost_callback() {
        ob_clean(); // Clear any previous output
    
        if (!isset($_POST['data'])) {
            wp_send_json_error(['message' => 'Missing data parameter']);
        }
    
        $data = $_POST['data'];
        $calculated_cost_arr = [];

        $costing_value = (json_decode(get_option('cphu_costing_data'), true) !="")? json_decode(get_option('cphu_costing_data'), true) : [];
        $makka_hotel_costing = get_post_meta($data['hotelId']['makka'], 'hotel_costing_object');
        $madina_hotel_costing = get_post_meta($data['hotelId']['madina'], 'hotel_costing_object');
    
        // print_r($data);



        foreach($data as $key=>$element){
            // Travellers
            if($key === 'travellers'){
                $calculated_cost_arr []= [
                    "Name: " => "Travelers: ",
                    "description" => "Adult(".$element['adult']."), Children(".$element['children']."), Infant(".$element['infant'].")",
                    "cost" => [
                        'adult' => "-",
                        'children' => "-",
                        'infant' => "-",
                        'total' => "-",
                    ]
                ];
            }

            // Flight Type
            if($key === 'flightType'){
                $calculated_cost_arr []= [
                    "Name: " => "Flight Type: ",
                    "description" => $element."",
                    "cost" => [
                        'adult' => "-",
                        'children' => "-",
                        'infant' => "-",
                        'total' => "-",
                    ]
                ];
            }

            // Air Ticket Type
            if($key === 'airTicketType'){
                $formatted_string = "cphu-" . strtolower(str_replace(" ", "-", $element));

                $calculated_cost_arr []= [
                    "Name: " => "Air Ticket Type: ",
                    "description" => $element."",
                    "cost" => [
                        'adult' => $costing_value[$formatted_string . "-adult"],
                        'children' => $costing_value[$formatted_string . "-children"],
                        'infant' => $costing_value[$formatted_string . "-infant"],
                        'total' => (float)$costing_value[$formatted_string . "-adult"] + (float)$costing_value[$formatted_string . "-children"] + (float)$costing_value[$formatted_string . "-infant"],
                    ]
                ];
            }

            //Airlines
            if($key === 'airlines'){
                $calculated_cost_arr []= [
                    "Name: " => "Airlines: ",
                    "description" => $element,
                    "cost" => [
                        'adult' => "-",
                        'children' => "-",
                        'infant' => "-",
                        'total' => "-",
                    ]
                ];
            }

            // Route
            if($key === 'route'){
                $formatted_string = "cphu-route-" . strtolower($element);

                $calculated_cost_arr []= [
                    "Name: " => "Route: ",
                    "description" => $element."",
                    "cost" => [
                        'adult' => "-",
                        'children' => "-",
                        'infant' => "-",
                        'total' => $costing_value[$formatted_string]
                    ]
                ];
            }

            // Visa Service
            if($key === 'visaService'){
                if($element = 'yes'){
                    $calculated_cost_arr []= [
                        "Name: " => "Visa Service: ",
                        "description" => strtoupper($element)."",
                        "cost" => [
                            'adult' => $costing_value['cphu-visa-cost-adult'],
                            'children' => $costing_value['cphu-visa-cost-children'],
                            'infant' => $costing_value['cphu-visa-cost-infant'],
                            'total' => (float)$costing_value['cphu-visa-cost-adult'] + (float)$costing_value['cphu-visa-cost-children'] + (float)$costing_value['cphu-visa-cost-infant']
                        ]
                    ];
                }
            }

            // Guide
            if ($key === 'guide') {
                if (!empty($element) && is_array($element)) { // Ensure $element is an array
                    $total_guide_cost = 0;
                    $guide_names = [];
            
                    foreach ($element as $val) {
                        $guide_names[] = strtoupper(str_replace('_', " ", $val));
                        $total_guide_cost += isset($costing_value["cphu-" . strtolower(str_replace("_", "-", $val)) . "-guide"])
                            ? (float)$costing_value["cphu-" . strtolower(str_replace("_", "-", $val)) . "-guide"]
                            : 0; // Prevent undefined index error
                    }
            
                    $calculated_cost_arr[] = [
                        "Name: " => "Guide: ",
                        "description" => implode(", ", $guide_names), // Convert array to string
                        "cost" => [
                            'adult' => '-',
                            'children' => '-',
                            'infant' => '-',
                            'total' => $total_guide_cost // Assign total cost separately
                        ]
                    ];
                }
            }

            // Transport
            if ($key === 'transport') {
                if (!empty($element) && is_array($element)) { // Ensure $element is an array
                    $total_transport_cost = 0;
                    $transport_names = [];
            
                    foreach ($element as $val) {
                        $transport_names[] = "<span class='list'>" . strtoupper(str_replace('_', " ", $val)) . "</span>";
                        $total_transport_cost += isset($costing_value["cphu_transport_" .  $val . "_seater"])
                            ? (float)$costing_value["cphu_transport_" .  $val . "_seater"]
                            : 0; // Prevent undefined index error
                    }
            
                    $calculated_cost_arr[] = [
                        "Name: " => "Transport: ",
                        "description" => implode(", ", $transport_names), // Convert array to string
                        "cost" => [
                            'adult' => '-',
                            'children' => '-',
                            'infant' => '-',
                            'total' => $total_transport_cost // Assign total cost separately
                        ]
                    ];
                }
            }

            // Hotel name
            if($key === 'hotelId'){
                $calculated_cost_arr['hotel'] []= [
                    "Name: " => "Hotel Name: ",
                    [
                        'makka' => [
                            "description" => get_the_title($element['makka']),
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => "-",
                            ]
                        ], 
                        'madina' => [
                            "description" => get_the_title($element['madina']),
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => "-",
                            ]
                        ],
                    ],
                    
                ];
            }

            // Hotel Stay
            if($key === 'hotelStay'){
                $stayDurations = [];

                foreach ($element as $city => $dates) {
                    $from = new DateTime($dates['from']);
                    $to = new DateTime($dates['to']);
                    $days = $from->diff($to)->days; // Calculate difference in days

                    $stayDurations[$city] = $days;
                }

                $calculated_cost_arr['hotel'][] = [
                    "Name: " => "Hotel Stay: ",
                    [
                        'makka' => [
                            "description" => $stayDurations['makka']. " Day(s) (".$dates['from']." - ".$dates['to'].")",
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => "-",
                            ]
                        ], 
                        'madina' => [
                            "description" => $stayDurations['madina']. " Day(s) (".$dates['from']." - ".$dates['to'].")",
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => "-",
                            ]
                        ],
                    ],
                    
                ];
            }

            // Hotel request
            if($key === 'message'){
                $calculated_cost_arr['hotel'] []= [
                    "Name: " => "Request: ",
                    [
                        'makka' => [
                            "description" => $element['makka'],
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => "-",
                            ]
                        ], 
                        'madina' => [
                            "description" => $element['madina'],
                            "cost" => [
                                'adult' => "-",
                                'children' => "-",
                                'infant' => "-",
                                'total' => "-",
                            ]
                        ],
                    ],
                    
                ];
            }
            
        }

        //Room and food
        if ((array_key_exists("rooms", $data)) && (array_key_exists("food", $data))){
            $pricingData = [
                'makka' => $makka_hotel_costing,
                'madina' => $madina_hotel_costing
            ];
            $result = calculateCost($data['hotelStay'], $data['rooms'], $data['food'], $pricingData);
            $calculated_cost_arr['hotel'] []= $result[0];
        }
        // print_r($calculated_cost_arr);
        // die();
;
    
        wp_send_json_success(['received_data' => $calculated_cost_arr]);
    }
    add_action('wp_ajax_calculate_cost', 'calculate_cost_callback');
    add_action('wp_ajax_nopriv_calculate_cost', 'calculate_cost_callback');
    
?>