<?php

namespace GS\GenericParts;

use function Symfony\Component\String\u;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	public function __construct(
		private $locale,
		private $timezone,
	) {}
	
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder('gs_generic_parts');
		
		$treeBuilder->getRootNode()
			->children()
			
			
				->scalarNode('locale')
					->info('Locale for services')
					#->defaultValue('%gs_generic_parts.locale%') Don't work, it's a simple string if defaultValue
					->defaultValue($this->locale)
				->end()
			
				->scalarNode('timezone')
					->info('Timezone for services')
					->defaultValue($this->timezone)
				->end()
				
				
			->end()

			->append($this->errorLogger())
		
			->append($this->generalParts())
		;
		
		//$treeBuilder->setPathSeparator('/');
		
		return $treeBuilder;
	}
	
	//###> HELPERS ###
	
	private function errorLogger() {
		$treeBuilder = new TreeBuilder('error_logger_email');
		
		return $treeBuilder->getRootNode()
			->info('Set exactly both emails to enable sending emails when prod. Default: donot send emails.')
				->children()
				->scalarNode('from')
					->info('From this email will be sending letters about errors on this site')
					->defaultFalse() # not null to figure out when user doesn't pass value
				->end()
				->scalarNode('to')
					->info('To this email will be sending letters about errors on this site')
					->defaultFalse()
				->end()
			->end()
		;
	}
	
	private function generalParts() {
		$treeBuilder = new TreeBuilder('general_parts');
		
		return $treeBuilder->getRootNode()
			->info('Тестовый всевозможный вариант treeBuilder')
			->children()
				
				->arrayNode('white_list')							# array node
					->info('May be a string')
					->beforeNormalization()->castToArray()->end()	# when it isn't an array change it into an array
					->scalarPrototype()->end()						# of scalar elements
				->end()
				
				
				->arrayNode('author')											# may be a string because
					->info('May be as a email string only')
					->beforeNormalization()
						->ifString()											# if string
						->then(static fn($v) => ['name' => $v, 'email' => $v])	# return required fields as array
					->end()
					->children()
					
						->scalarNode('name')
							->info('cannot be overwritten and always have a prefix name_')
							->isRequired()
							->cannotBeOverwritten()								# it writes down one time only
							->beforeNormalization()
								->always()														# always
								->then(static fn($v) => (string) u($v)->ensureStart('name_'))	# add name_ pref
							->end()
						->end()
						->scalarNode('email')->isRequired()->end()
						->floatNode('age')->min(0)->max(150)->end()
						
					->end()
				->end()
				
				
				->arrayNode('servers')
					->info('May be as a string and only overwritten case (no merge)')
					->treatNullLike(['main' => ['domain' => 'localhost']])	# if servers: ~
					->useAttributeAsKey('name')	# exactly use as an associal element
					->isRequired()				# require
					->performNoDeepMerging()	# include only the last config
					->normalizeKeys(false)		# don't normalize keys
					->beforeNormalization()
						->ifString()
						->then(static fn($v) => ['main' => ['domain' => $v]])
					->end()
					->arrayPrototype()			# exactly here
						->info('May be as a domain string only')
						->beforeNormalization()
							->ifString()
							->then(static fn($v) => ['domain' => $v])
						->end()
						->addDefaultsIfNotSet()	# and include it even withous manually set
						->treatNullLike(['domain' => null])
						->children()
						
							->enumNode('host')
								->info('cannot be empty')
								->cannotBeEmpty()
								->values(['http', 'https'])
							->end()
							->scalarNode('domain')
								->info('default: localhost')
								->cannotBeEmpty()
								->defaultValue('localhost') # if default exists it cannot be isRequired!
								->treatNullLike('localhost')
							->end()
							->scalarNode('port')
								->info('null throws an Exception')
								->cannotBeEmpty()
								->validate()
									->ifNull()
									->thenInvalid('port is %s but it can\'t be this value')
								->end()
							->end()
							
						->end()					
					->end()
				->end()
				
				
				->scalarNode('data_provider')
					->info('Client may set his own data provider passing service name.')
					->defaultNull()
				->end()
				
				
			->end()
		;
	}
}