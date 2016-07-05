<?php

// Load event listeners
App::uses('CakeEventManager', 'Event');
App::uses('NotificationListener', 'Lib/Event');

// Attach listeners.
CakeEventManager::instance()->attach(new NotificationListener());
