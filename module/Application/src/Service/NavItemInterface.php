<?php
namespace Application\Service;

use Application\Service\NavComponentInterface;

interface NavItemInterface extends NavComponentInterface
{
  function getId();
  function getFloat();
  function setActive($active);
  function render();
}
