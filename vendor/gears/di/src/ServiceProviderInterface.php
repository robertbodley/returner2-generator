<?php namespace Gears\Di;
////////////////////////////////////////////////////////////////////////////////
// __________ __             ________                   __________              
// \______   \  |__ ______  /  _____/  ____ _____ ______\______   \ _______  ___
//  |     ___/  |  \\____ \/   \  ____/ __ \\__  \\_  __ \    |  _//  _ \  \/  /
//  |    |   |   Y  \  |_> >    \_\  \  ___/ / __ \|  | \/    |   (  <_> >    < 
//  |____|   |___|  /   __/ \______  /\___  >____  /__|  |______  /\____/__/\_ \
//                \/|__|           \/     \/     \/             \/            \/
// -----------------------------------------------------------------------------
//          Designed and Developed by Brad Jones <brad @="bjc.id.au" />         
// -----------------------------------------------------------------------------
////////////////////////////////////////////////////////////////////////////////

interface ServiceProviderInterface
{
	/**
	 * Method: register
	 * =========================================================================
	 * Registers services on the given container.
	 * 
	 * *This method should only be used to configure services and parameters.
	 * It should not get services.*
	 * 
	 * Parameters:
	 * -------------------------------------------------------------------------
	 * - $container: An instance of the ```Gears\Di\Container```.
	 * 
	 * Returns:
	 * -------------------------------------------------------------------------
	 * void
	 */
	public function register(Container $container);
}