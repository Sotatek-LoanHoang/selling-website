<?php
namespace Application\Service;

interface NavItemInterface
{
  function getId();
  function getFloat();
  function setActive($active);
  function render();
}
