<?php

function pr($s) {
	if (class_exists('Debugger')) {
		Debugger::pr($s);
	}
}