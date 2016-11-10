<?php
namespace Objection\Internal\Build\Descriptors;


class SourceFile
{
	private $sourceFile;
	
	private $content;
	
	
	private function loadContent()
	{
		if (!$this->content)
		{
			$this->content = file_get_contents($this->sourceFile);
			
			if (!$this->content)
			{
				throw new \Exception("Could not read the content of " . $this->sourceFile);
			}
		}
	}
	
	
	public function __construct($filePath)
	{
		$this->sourceFile = $filePath;
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
	 * @param string $path
	 */
	public function resolveNamespaceFor($path)
	{
		
	}
}