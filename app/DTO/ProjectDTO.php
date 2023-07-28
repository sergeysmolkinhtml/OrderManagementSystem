<?php

namespace App\DTO;

final class ProjectDTO
{
    public static function getArray(array $data) : array
    {
        $self = [];
        if (array_key_exists('id', $data))
            $self['id'] = $data['id'];
        if (array_key_exists('name', $data))
            $self['name'] = $data['name'];
        if (array_key_exists('image', $data))
            $self['image'] = $data['image'];

        return $self;
    }
}
