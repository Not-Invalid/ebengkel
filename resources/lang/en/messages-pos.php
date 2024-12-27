<?php
return [
    'title' => 'eBengkelku | POS',
    'header' => 'Dashboard',
    'stat' => [
        'total_services' => 'Total Services',
        'total_products' => 'Total Products',
        'total_spareparts' => 'Total Spareparts',
        'orders_this_month' => 'Orders This Month',
    ],
    'orders' => [
        'online_orders' => 'Online Orders',
        'view_more' => 'View More',
        'order_id' => 'Order ID',
        'customer' => 'Customer',
        'status' => 'Status',
        'order_date' => 'Order Date',
        'action' => 'Action',
        'detail' => 'Detail',
        'no_orders_found' => 'No orders found.',
        'statuses' => [
            'PENDING' => 'Pending Payment',
            'Waiting_Confirmation' => 'Waiting Confirmation',
            'DIKEMAS' => 'Packed',
            'DIKIRIM' => 'Shipped',
            'SELESAI' => 'Completed',
            'unknown' => 'Unknown',
        ],
    ],
    'top_products' => [
        'title' => 'Top 5 Products',
        'select_period' => 'Select Period',
        'periods' => [
            'day' => 'Today',
            'week' => 'Week',
            'month' => 'Month',
            'year' => 'This Year',
        ],
        'online' => 'Online',
        'offline' => 'Offline',
        'unknown_product' => 'Unknown Product',
    ],
    'top_spareparts' => [
        'title' => 'Top 5 Spareparts',
        'select_period' => 'Select Period',
    ],
];
