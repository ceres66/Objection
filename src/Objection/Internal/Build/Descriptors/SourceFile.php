<?php
namespace Objection\Internal\Build\Descriptors;


use Objection\Internal\Build\DataTypes\TypeFactory;
use Objection\Internal\Build\DataTypes\Base\INamespaceParser;


class SourceFile implements INamespaceParser
{
	private $sourceFile;
	private $content = null;
	
	/** @var TypeFactory */
	private $typeFactory;
	

	/**
	 * @param string $filePath
	 */
	public function __construct($filePath)
	{
		$this->sourceFile = $filePath;
		$this->typeFactory = new TypeFactory($this);
	}


	/**
	 * @return string
	 */
	public function getSourceFile()
	{
		return $this->sourceFile;
	}
	
	/**
	 * @return string
	 */
	public function getNamespace()
	{
		
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		if (!$this->content)
		{
			$this->content = file_get_contents($this->sourceFile);
			
			if (!$this->content)
			{
				throw new \Exception("Could not read the content of " . $this->sourceFile);
			}
		}
		
		return $this->content;
	}

	/**
	 * @param string $path
	 * @return bool|string
	 */
	public function resolveNamespaceFor($path)
	{
		
	}

	/**
	 * @return TypeFactory
	 */
	public function getTypeFactory()
	{
		return $this->typeFactory;
	}
}