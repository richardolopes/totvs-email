<?php

namespace Totvs\Model;

use Totvs\Controller\HttpProtheusRobot;

class ProtheusRobot
{
	private string $rpo;
	private string $release;
	private string $squad_name;
	private string $date;

	public function __construct(string $rpo = 'RPO_D-1', string $release, string $squad_name, string $date)
	{
		$this->setRpo($rpo);
		$this->setRelease($release);
		$this->setSquadName($squad_name);
		$this->setDate($date);
	}

	public function getRpo(): string {
		return $this->rpo;
	}

	public function setRpo(string $value): void {
		$this->rpo = $value;
	}

	public function getRelease(): string {
		return $this->release;
	}

	public function setRelease(string $value): void {
		$this->release = $value;
	}

	public function getSquadNameURL(): string {
		return urlencode($this->squad_name);
	}

	public function getSquadName(): string {
		return $this->squad_name;
	}

	public function setSquadName(string $value): void {
		$this->squad_name = $value;
	}

	public function getDate(): string {
		return $this->date;
	}

	public function setDate(string $value): void {
		if (empty($value) || !isset($value)) {
			$this->date = Util::recentDate(HttpProtheusRobot::getDates($this->getRelease(), $this->getRpo()));
		} else {
			$this->date = $value;
		}
	}
}
