<?php

interface AbleToLunch {
    public function goToLunch();
}

interface AccessibleToRoom {
    public function checkAccess();
}


class Student implements AbleToLunch, AccessibleToRoom {


    public function checkAccess() {

    }

    public function goToLunch()
    {
        // TODO: Implement goToLunch() method.
    }
}
