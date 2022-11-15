import React, {useState} from 'react';
import {AlertDialog, Button, Center, FormControl, Heading, Icon, Input, Modal, Radio, Stack, TextArea} from 'native-base';
import {MaterialIcons} from '@expo/vector-icons';
import {clearListTitles, deleteList, editList} from '../../../util/loadPatron';
import {popAlert} from '../../../components/loadError';

const EditList = (props) => {
	const {data, listId, navigation, libraryUrl, loadList, _updateRouteParam, _updateListDetail} = props;
	const [showModal, setShowModal] = useState(false);
	const [loading, setLoading] = useState(false);
	const [title, setTitle] = useState(null);
	const [description, setDescription] = useState(null);
	console.log(data.public);

	let accessType = Boolean(false);
	if (data.public === true || data.public === 'true' || data.public === 1) {
		accessType = Boolean(true);
	}
	const [access, setAccess] = useState(Boolean(access));

	return (
			<Center>
				<Button.Group size="sm" justifyContent="center" pb={5}>
					<Button
							onPress={() => setShowModal(true)}
							leftIcon={<Icon as={MaterialIcons} name="edit" size="xs"/>}
					>
						Edit</Button>
					<DeleteList navigation={navigation} listId={listId} libraryUrl={libraryUrl}/>
				</Button.Group>
				<Modal isOpen={showModal} onClose={() => setShowModal(false)} size="full" avoidKeyboard>
					<Modal.Content maxWidth="90%" bg="white" _dark={{bg: 'coolGray.800'}}>
						<Modal.CloseButton/>
						<Modal.Header>
							<Heading size="sm">Edit {data.title}</Heading>
						</Modal.Header>
						<Modal.Body>
							<FormControl pb={5}>
								<FormControl.Label>Name</FormControl.Label>
								<Input
										id="title"
										defaultValue={data.title}
										autoComplete="off"
										onChangeText={text => setTitle(text)}
								/>
							</FormControl>
							<FormControl pb={5}>
								<FormControl.Label>Description</FormControl.Label>
								<TextArea
										id="description"
										defaultValue={data.description}
										autoComplete="off"
										onChangeText={text => setDescription(text)}
								/>
							</FormControl>
							<FormControl>
								<FormControl.Label>Access</FormControl.Label>
								<Radio.Group value={access} onChange={nextValue => {
									setAccess(nextValue);
								}}>
									<Stack direction="row" alignItems="center" space={4} w="75%" maxW="300px">
										<Radio value="false" my={1}>Private</Radio>
										<Radio value="true" my={1}>Public</Radio>
									</Stack>
								</Radio.Group>
							</FormControl>
						</Modal.Body>
						<Modal.Footer>
							<Button.Group>
								<Button variant="outline" onPress={() => setShowModal(false)}>Cancel</Button>
								<Button
										isLoading={loading}
										isLoadingText="Saving..."
										onPress={() => {
											setLoading(true);
											editList(data.id, title, description, access, libraryUrl).then(r => {
												setLoading(false);
												setShowModal(false);
												_updateRouteParam(title);
												_updateListDetail('title', title);
												_updateListDetail('description', description);
												_updateListDetail('public', access);
											});
										}}>Save</Button>
							</Button.Group>
						</Modal.Footer>
					</Modal.Content>
				</Modal>
			</Center>
	);
};

const DeleteList = (props) => {
	const {navigation, listId, libraryUrl} = props;
	const [isOpen, setIsOpen] = React.useState(false);
	const [loading, setLoading] = useState(false);
	const onClose = () => setIsOpen(false);
	const cancelRef = React.useRef(null);

	return (
			<Center>
				<Button
						onPress={() => setIsOpen(!isOpen)}
						startIcon={<Icon as={MaterialIcons} name="delete" size="xs"/>}
						size="sm"
						colorScheme="danger"
				>
					Delete List
				</Button>
				<AlertDialog leastDestructiveRef={cancelRef} isOpen={isOpen} onClose={onClose}>
					<AlertDialog.Content>
						<AlertDialog.CloseButton/>
						<AlertDialog.Header>Delete List</AlertDialog.Header>
						<AlertDialog.Body>
							Are you sure you want to delete this list?
						</AlertDialog.Body>
						<AlertDialog.Footer>
							<Button.Group space={2}>
								<Button variant="unstyled" colorScheme="coolGray" onPress={onClose} ref={cancelRef}>
									Cancel
								</Button>
								<Button
										isLoading={loading}
										isLoadingText="Deleting..."
										colorScheme="danger"
										onPress={
											() => {
												setLoading(true);
												deleteList(listId, libraryUrl).then(res => {
													setLoading(false);
													let status = 'success';
													if (res.success === false) {
														status = 'danger';
														setIsOpen(!isOpen);
														popAlert('Unable to delete list', res.message, status);
													} else {
														popAlert('List deleted', res.message, status);
														navigation.navigate('AccountScreenTab', {
															screen: 'Lists',
															params: {libraryUrl: libraryUrl},
														});
													}
												});
											}
										}
								>
									Delete
								</Button>
							</Button.Group>
						</AlertDialog.Footer>
					</AlertDialog.Content>
				</AlertDialog>
			</Center>
	);
};

const ClearList = (props) => {
	const {navigation, listId} = props;
	const [isOpen, setIsOpen] = React.useState(false);
	const [loading, setLoading] = useState(false);
	const onClose = () => setIsOpen(false);
	const cancelRef = React.useRef(null);

	return (
			<Center>
				<Button
						onPress={() => setIsOpen(!isOpen)}
						startIcon={<Icon as={MaterialIcons} name="delete" size="xs"/>}
				>
					Delete All Items
				</Button>
				<AlertDialog leastDestructiveRef={cancelRef} isOpen={isOpen} onClose={onClose}>
					<AlertDialog.Content>
						<AlertDialog.CloseButton/>
						<AlertDialog.Header>Delete All Items</AlertDialog.Header>
						<AlertDialog.Body>
							This will remove all data relating to Alex. This action cannot be
							reversed. Deleted data can not be recovered.
						</AlertDialog.Body>
						<AlertDialog.Footer>
							<Button.Group space={2}>
								<Button variant="unstyled" colorScheme="coolGray" onPress={onClose} ref={cancelRef}>
									Cancel
								</Button>
								<Button
										isLoading={loading}
										isLoadingText="Deleting..."
										colorScheme="danger"
										onPress={
											() => {
												setLoading(true);
												clearListTitles(listId).then(r => setLoading(false));
											}
										}
								>
									Delete
								</Button>
							</Button.Group>
						</AlertDialog.Footer>
					</AlertDialog.Content>
				</AlertDialog>
			</Center>
	);
};

export default EditList;