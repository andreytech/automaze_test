<?php
session_start();
require '../env_consts.php';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Tracker</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.0.0"></script>
    <script>
        if (!!window.EventSource) {
            var source = new EventSource('/notifications.php');
            source.addEventListener('message', function (e) {
                var data = JSON.parse(e.data);
                if(!data) return;
                var alertBox = document.createElement('div');
                alertBox.classList.add('p-4', 'bg-green-100', 'text-green-800', 'rounded', 'mt-4');
                alertBox.innerText = `Bug Status Updated: ${data.status}. Comment: ${data.comment || 'No comment'}`;
                document.body.appendChild(alertBox);
            }, false);
        }
    </script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
<div>
    <h1 class="text-4xl mb-4">Hello World</h1>
    <button class="bg-blue-500 text-white px-4 py-2"
            hx-get="/report_bug.php" hx-trigger="click"
            hx-target="#bug-report-form">
        Report a Bug
    </button>
    <div id="bug-report-form"></div>
</div>
</body>
</html>
